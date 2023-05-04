<?php
namespace App\Http\Controllers\Api\Archives;

use App\Enums\ArchiveTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditArchiveRequest;
use App\Models\Archive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EditArchiveController extends Controller
{
    public function edit(EditArchiveRequest $request, string $nisn)
    {
        $rows = $request->all();
        $archive = Archive::where('nisn', $nisn);
        if (!$archive->exists()) {
            return response()->json([
                'error' => 'NISN isn\'t registered',
            ], 400);
        }

        if (strcmp($rows['type'], $archive->value('type')) != 0) {
            return response()->json([
                'error' => 'Archive type doesn\'t match',
            ], 400);
        } else if ($rows['birthday'] != $archive->value('birthday')) {
            return response()->json([
                'error' => 'Birth doesn\'t match',
            ], 400);
        }

        $rows['birthday'] = $archive->value('birthday');

        $photo = $request->file('photo');
        $rows['photo_path'] = $photo->storePubliclyAs('photos',
            $this->generate_filename(
                $photo->extension(),
            ),
        );

        if ($archive->value('photo_path') !== null && isset($photo)) {
            unset($rows['photo']);
            Storage::delete($archive->value('photo_path'));
        }

        $skhu = $request->file('skhu');
        $rows['skhu_path'] = $skhu->storePubliclyAs('skhus',
            $this->generate_filename(
                $skhu->extension(),
            ),
        );

        if ($archive->value('skhu_path') !== null && isset($skhu)) {
            unset($rows['skhu']);
            Storage::delete($archive->value('skhu_path'));
        }

        switch($archive->value('type')) {
            case ArchiveTypes::PRESTASI:
                $prestasi_file = $request->file('certificate');
                $rows['certificate_path'] = $prestasi_file->storePubliclyAs('certificates',
                    $this->generate_filename(
                        $prestasi_file->extension()),
                );

                if ($archive->value('certificate_path') !== null && isset($prestasi_file)) {
                    Storage::delete($archive->value('certificate_path'));
                }
                unset($rows['certificate']);
                break;
            case ArchiveTypes::AFIRMASI:
                $afirmasi_file = $request->file('kip');
                $rows['kip_path'] = $afirmasi_file->storePubliclyAs('kips',
                    $this->generate_filename(
                        $afirmasi_file->extension(),
                    ),
                );
                
                if ($archive->value('kip_path') !== null && isset($afirmasi_file)) {
                    Storage::delete($archive->value('kip_path'));
                }
                unset($rows['kip']);
                break;
            case ArchiveTypes::MUTASI:
                $mutasi_file = $request->file('mutation');
                $rows['mutation_path'] = $mutasi_file->storePubliclyAs('mutations',
                    $this->generate_filename(
                        $mutasi_file->extension(),
                    ),
                );

                if ($archive->value('mutation_path') !== null && isset($mutasi_file)) {
                    Storage::delete($archive->value('mutation_path'));
                }
                unset($rows['mutation']);
                break;
            default:
                $kk_file = $request->file('kk');
                $rows['kk_path'] = $kk_file->storePubliclyAs('kks',
                    $this->generate_filename(
                        $kk_file->extension(),
                    ),
                );

                if ($archive->value('kk_path') !== null && isset($kk_file)) {
                    Storage::delete($archive->value('kk_path'));
                }
                unset($rows['kk']);
                break;
        }

        $archive->update($rows);

        return response()->json(['data' => $archive, 'message' => 'Edited']);
    }

    protected function generate_filename(string $ext): string
    {
        return sprintf("%s.%s", Str::uuid(), $ext);
    }
}
