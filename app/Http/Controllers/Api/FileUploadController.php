<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Document;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|integer',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        $assetId = $request->input('asset_id');

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $path = $photo->store('uploads/photos', 'public');
                Photo::create([
                    'asset_id' => $assetId,
                    'file_path' => $path,
                ]);
            }
        }

        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $document) {
                $path = $document->store('uploads/documents', 'public');
                Document::create([
                    'asset_id' => $assetId,
                    'file_path' => $path,
                ]);
            }
        }

        return successResponse('Files uploaded successfully');
    }
}
