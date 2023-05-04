<?php
namespace App\Http\Controllers\Api\Archives;

use App\Enums\ArchiveTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddArchiveRequest;
use App\Models\Archive;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AddArchiveController extends Controller
{
    public function store(AddArchiveRequest $request)
    {
        $rows = $request->all();

        $archive = Archive::where('nisn', $rows['nisn']);
        if ($archive->exists()) {
            return response()->json([
                'error' => 'This archive which contains NISN is exists',
            ], 400);
        }

        $photo = $request->file('photo');
        $rows['photo_path'] = $photo->storePubliclyAs('photos', $this->generate_filename($photo->extension()));

        $skhu = $request->file('skhu');
        $rows['skhu_path'] = $skhu->storePubliclyAs('skhus', $this->generate_filename($skhu->extension()));

        switch($rows['type']) {
            case ArchiveTypes::PRESTASI:
                $prestasi_file = $request->file('certificate');
                $rows['certificate_path'] = $prestasi_file->storePubliclyAs('certificates', $this->generate_filename($prestasi_file->extension()));
                unset($rows['certificate']);
                break;
            case ArchiveTypes::AFIRMASI:
                $afirmasi_file = $request->file('kip');
                $rows['kip_path'] = $afirmasi_file->storePubliclyAs('kips', $this->generate_filename($afirmasi_file->extension()));
                unset($rows['kip']);
                break;
            case ArchiveTypes::MUTASI:
                $mutasi_file = $request->file('mutation');
                $rows['mutation_path'] = $mutasi_file->storePubliclyAs('mutations', $this->generate_filename($mutasi_file->extension()));
                unset($rows['mutation']);
                break;
            default:
                $kk_file = $request->file('kk');
                $rows['kk_path'] = $kk_file->storePubliclyAs('kks', $this->generate_filename($kk_file->extension()));
                unset($rows['kk']);
                break;
        }

        $rows['birthday'] = Carbon::parse($rows['birthday'], config('app.timezone'))->toDateString();

        unset($rows['photo']);
        unset($rows['skhu']);
    
        $archive = Archive::create($rows);
        return response()->json([
            'error' => null,
            'data' => $archive,
        ]);
    }

    protected function generate_filename(string $ext): string
    {
        return sprintf("%s.%s", Str::uuid(), $ext);
    }
}