<?php
namespace App\Http\Controllers\Api\Archives;

use App\Enums\ArchiveTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditArchiveRequest;
use App\Models\Archive;

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
        } else if (strtotime($rows['birthday']) != strtotime($archive->value('birthday'))) {
            return response()->json([
                'error' => 'Birth doesn\'t match',
            ], 400);
        }

        $rows['birthday'] = $archive->value('birthday');

        $photo = $request->file('photo');
        $rows['photo_path'] = $photo->storePubliclyAs('photos',
            $this->generate_filename(
                $this->__extract_uuid($archive->value('photo_path')),
                $photo->extension(),
            ),
        );

        $skhu = $request->file('skhu');
        $rows['skhu_path'] = $skhu->storePubliclyAs('skhus',
            $this->generate_filename(
                $this->__extract_uuid($archive->value('skhu_path')),
                $skhu->extension(),
            ),
        );

        switch($archive->value('type')) {
            case ArchiveTypes::PRESTASI:
                $prestasi_file = $request->file('certificate');
                $rows['certificate_path'] = $prestasi_file->storePubliclyAs('certificates',
                    $this->generate_filename(
                        $this->__extract_uuid($archive->value('certificate_path')),
                        $prestasi_file->extension()),
                );
                unset($rows['certificate']);
                break;
            case ArchiveTypes::AFIRMASI:
                $afirmasi_file = $request->file('kip');
                $rows['kip_path'] = $afirmasi_file->storePubliclyAs('kips',
                    $this->generate_filename(
                        $this->__extract_uuid($archive->value('kip_path')),
                        $afirmasi_file->extension(),
                    ),
                );
                unset($rows['kip']);
                break;
            case ArchiveTypes::MUTASI:
                $mutasi_file = $request->file('mutation');
                $rows['mutation_path'] = $mutasi_file->storePubliclyAs('mutations',
                    $this->generate_filename(
                        $this->__extract_uuid($archive->value('mutation_path')),
                        $mutasi_file->extension(),
                    ),
                );
                unset($rows['mutation']);
                break;
            default:
                $kk_file = $request->file('kk');
                $rows['kk_path'] = $kk_file->storePubliclyAs('kks',
                    $this->generate_filename(
                        $this->__extract_uuid($archive->value('kk_path')),
                        $kk_file->extension(),
                    ),
                );
                unset($rows['kk']);
                break;
        }

        unset($rows['photo']);
        unset($rows['skhu']);

        $archive->update($rows);

        return response()->json(['data' => $archive, 'message' => 'Edited']);
    }

    protected function __extract_uuid(string $t): string
    {
        return explode('.', $t)[0];
    }

    protected function generate_filename(string $uid, string $ext): string
    {
        return sprintf("%s.%s", str_replace('/', '', preg_replace("([a-zA-Z]+)", '', $uid)), $ext);
    }
}
