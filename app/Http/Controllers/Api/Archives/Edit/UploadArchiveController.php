<?php
namespace App\Http\Controllers\Api\Archives\Edit;

use App\Enums\ArchiveTypes;
use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;

class UploadArchiveController extends Controller
{
    public function upload(Request $request)
    {
        $archive = auth('archive')->user();
        $archive = Archive::where('nisn', $archive->nisn);
        if (!$archive->exists()) {
            return response()->json([
                'error' => 'Archive doesn\'t exist',
                'data' => null,
            ], 400);
        }
        $type = $archive->value('type');

        $request->validate([
            'photo' => [
                Rule::requiredIf($archive->value('photo_path') === null),
                File::image(),
                'max:1024',
            ],
            'skhu' => [
                Rule::requiredIf($archive->value('skhu_path') === null),
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'certificate' => [
                Rule::requiredIf(
                    $type === ArchiveTypes::PRESTASI &&
                        $archive->value('certificate_path') === null
                ),
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'kip' => [
                Rule::requiredIf($type === ArchiveTypes::AFIRMASI && $archive->value('kip_path') === null),
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'mutation' => [
                Rule::requiredIf(
                    $type === ArchiveTypes::MUTASI &&
                        $archive->value('mutation_path') === null
                ),
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'kk' => [
                Rule::requiredIf(
                    $type === ArchiveTypes::ZONASI &&
                        $archive->value('kk_path') === null
                ),
                File::types(['pdf']),
                'max:1024',
            ],
        ]);

        $rows = $request->all();

        $photo = $request->file('photo');
        if (isset($photo)) {
            $rows['photo_path'] = $photo->storePubliclyAs('public/photos',
                $this->generate_filename(
                    $photo->extension(),
                ),
            );
            unset($rows['photo']);
        
            if ($archive->value('photo_path'))
                Storage::delete($archive->value('photo_path'));
        }

        $skhu = $request->file('skhu');
        if (isset($skhu)) {
            $rows['skhu_path'] = $skhu->storePubliclyAs('public/skhus',
                $this->generate_filename(
                    $skhu->extension(),
                ),
            );
            unset($rows['skhu']);
            if ($archive->value('skhu_path'))
                Storage::delete($archive->value('skhu_path'));
        }

        switch($archive->value('type')) {
            case 'prestasi':
                $prestasi_file = $request->file('certificate');
                if (isset($prestasi_file))
                    $rows['certificate_path'] = $prestasi_file->storePubliclyAs('public/certificates',
                        $this->generate_filename(
                            $prestasi_file->extension()),
                    );

                if ($archive->value('certificate_path') !== null && isset($prestasi_file)) {
                    Storage::delete($archive->value('certificate_path'));
                }
                unset($rows['certificate']);
                break;
            case 'afirmasi':
                $afirmasi_file = $request->file('kip');
                if (isset($afirmasi_file))
                    $rows['kip_path'] = $afirmasi_file->storePubliclyAs('public/kips',
                        $this->generate_filename(
                            $afirmasi_file->extension(),
                        ),
                    );
                
                if ($archive->value('kip_path') !== null && isset($afirmasi_file)) {
                    Storage::delete($archive->value('kip_path'));
                }
                unset($rows['kip']);
                break;
            case 'mutasi':
                $mutasi_file = $request->file('mutation');
                if (isset($mutasi_file))
                    $rows['mutation_path'] = $mutasi_file->storePubliclyAs('public/mutations',
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
                if (isset($kk_file))
                    $rows['kk_path'] = $kk_file->storePubliclyAs('public/kks',
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

        return response()->json([
            'error' => null,
            'message' => 'Archive uploaded',
            'data' => $rows,
        ]);
    }

    protected function generate_filename(string $ext): string
    {
        return sprintf("%s.%s", Str::uuid(), $ext);
    }
}