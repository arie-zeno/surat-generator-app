<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratController extends Controller
{
    // Halaman daftar template
    public function index()
    {
        $title = "Surat";
        // Ambil dari disk public
//        $templates = Storage::disk('public')->files('templates');
        $templates = Surat::all()->sortByDesc('created_at');
        return view('templates.index', compact('templates', 'title'));
    }

    // Upload template docx
    public function upload(Request $request)
    {
        try {


            $request->validate([
                'template' => 'required|max:5120',
            ]);

            $originalName = pathinfo($request->file('template')->getClientOriginalName(), PATHINFO_FILENAME);

// Bersihkan nama biar aman untuk filesystem (hapus spasi & karakter aneh)
            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $name = 'template_' . time() . "_" . $safeName . '.docx';

            // Simpan ke storage/app/public/templates
            $path = $request->file('template')->storeAs('templates', $name, 'public');

            // Simpan metadata ke database
            Surat::create([
                'nama_surat' => $request->nama_surat,
                'nama_file'   => $name,
                'file'          => $path,
            ]);

            return redirect()->route('templates.index')
                ->with('success', 'Template berhasil diupload');
        }catch (\Exception $exception){
            return redirect()->route('templates.index')
                ->with('success', $exception->getMessage());
        }
    }

    // Form input berdasarkan placeholder
//    public function create($file)
//    {
//        $path = storage_path('app/public/templates/' . $file);
//        $templateProcessor = new TemplateProcessor($path);
//
//        $placeholders = $templateProcessor->getVariables();
//        return view('templates.create', compact('file', 'placeholders'));
//    }

    public function create($id)
    {
        $title = "Surat";

        $helper = Helper::all();
        $template = Surat::findOrFail($id);
        $path = storage_path('app/public/' . $template->file);

        $tp = new TemplateProcessor($path);
        $placeholders = $tp->getVariables();

        return view('templates.create', [
            'template' => $template,
            'placeholders' => $placeholders,
            'title' => $title,
            'helper' => $helper
        ]);
    }

    // Generate surat (DOCX / PDF)
//    public function generate(Request $request, $file)
//    {
//        $path = storage_path('app/public/templates/' . $file);
//        $templateProcessor = new TemplateProcessor($path);
//
//        // Isi placeholder
//        foreach ($request->except(['_token', 'type']) as $key => $value) {
//            $templateProcessor->setValue($key, $value);
//        }
//
//        $filename = 'surat_' . time();
//        $docxPath = storage_path("app/public/generated/{$filename}.docx");
//        $templateProcessor->saveAs($docxPath);
//
//        if ($request->type === 'pdf') {
//            Settings::setPdfRendererName(Settings::PDF_RENDERER_MPDF);
//            Settings::setPdfRendererPath(base_path('vendor/mpdf/mpdf'));
//            $phpWord = IOFactory::load($docxPath);
//            $pdfPath = storage_path("app/public/generated/{$filename}.pdf");
//            $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
//            $pdfWriter->save($pdfPath);
//
//            return response()->download($pdfPath)->deleteFileAfterSend(true);
//        }
//
//        return response()->download($docxPath)->deleteFileAfterSend(true);
//    }

    public function generate(Request $request, $id)
    {
        $template = Surat::findOrFail($id);
        $path = storage_path('app/public/' . $template->file);

        $tp = new TemplateProcessor($path);

        foreach ($request->except(['_token', 'type']) as $key => $value) {
            $tp->setValue($key, $value);
        }

        $filename = 'surat_' . time();
        $docxPath = storage_path("app/public/generated/{$filename}.docx");
        $tp->saveAs($docxPath);

        if ($request->type === 'pdf') {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($docxPath);

            $pdfPath = storage_path("app/public/generated/{$filename}.pdf");
            $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
            $pdfWriter->save($pdfPath);

            return response()->download($pdfPath)->deleteFileAfterSend(true);
        }

        return response()->download($docxPath)->deleteFileAfterSend(true);
    }

    public function remove($id)
    {
        $template = Surat::findOrFail($id);
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus');
    }
}

