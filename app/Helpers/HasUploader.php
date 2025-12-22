<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait HasUploader
{
    private function upload(Request $request, string $input, string $oldFile = null): string
    {
        Log::info('📤 Upload started', [
            'input_name' => $input,
            'has_file'   => $request->hasFile($input),
            'all_files'  => array_keys($request->allFiles()),
        ]);

        if (!$request->hasFile($input)) {
            Log::error('❌ No file received', [
                'input' => $input,
            ]);
            throw new \Exception('No file received');
        }

        $file = $request->file($input);

        Log::info('📄 File received', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
            'is_valid'      => $file->isValid(),
        ]);

        if (!$file->isValid()) {
            Log::error('❌ Invalid uploaded file');
            throw new \Exception('Invalid uploaded file');
        }

        // ✅ Determine extension safely
        $ext = $file->getClientOriginalExtension()
            ?: $file->extension()
            ?: 'png';

        $filename = now()->timestamp . '-' . uniqid() . '.' . $ext;

        $path = 'uploads/' . date('y') . '/' . date('m') . '/';
        $filePath = $path . $filename;

        Log::info('🧩 File path resolved', [
            'disk'      => 'public',
            'file_path' => $filePath,
        ]);

        // Delete old file if exists
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Log::info('🗑️ Deleting old file', ['old_file' => $oldFile]);
            Storage::disk('public')->delete($oldFile);
        }

        try {
            Storage::disk('public')->put(
                $filePath,
                file_get_contents($file)
            );

            Log::info('✅ File uploaded successfully', [
                'stored_path' => $filePath,
                'public_url'  => Storage::url($filePath),
            ]);
        } catch (\Throwable $e) {
            Log::error('🔥 File upload failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            throw $e;
        }

        return $filePath;
    }
}