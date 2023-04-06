<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Mail;


class JsonController extends Controller
{
    public function index()
    {
        $filePath = public_path("test.pdf");
        $outputFilePath = public_path("templatePdf.pdf");
        $this->fillPDFFile($filePath, $outputFilePath);
        return response()->file($outputFilePath);
    }

    public function fillPDFFile($file, $output)
    {

        $pdf = new Fpdi();

        $pdf->setSourceFile($file);

        $template = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($template);
        $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($template);
        $pdf->setFont("helvetica", "", 15);
        $text = "Sohail Afzal";
        $pdf->Text(10, 10, $text);

        return $pdf->Output($output, 'F');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'document'  => 'required',
            'email'  => 'required'
        ]);
        $extension = '';
        if ($request->hasFile('document')) {
            $extension = request()->document->getClientOriginalExtension();
            $fileName =  time() . '.' . $extension;
            $folderName = "json/";
            $request->file('document')->storeAs('public/' . $folderName, $fileName);
            $file_path = storage_path('app/public/' . $folderName . $fileName);
            $data = file_get_contents($file_path);
            $json = str_replace('NaN', '"NaN"', $data);
            $users = json_decode($json, true);
        }

        $inputFile = public_path("test.pdf");
        $outputFile = public_path("templatePdf.pdf");

        $pdf = new Fpdi();

        $pdf->setSourceFile($inputFile);

        $template = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($template);
        $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($template);
        $pdf->setFont("helvetica", "", 10);
        $driverName =  "Driver Name:    " . $users['name'];
        $category =    "Category:          " . $users['Category'];
        $event =       "Event :              " . $users['eventName'];
        $track =       "Track :              " . $users['trackName'];
        $pdf->Text(10, 10, "Driver Info");
        $pdf->Text(15, 20, $driverName);
        $pdf->Text(15, 25, $category);
        $pdf->Text(15, 30, $event);
        $pdf->Text(15, 35, $track);

        $pdf->Text(100, 10, "Key Info");

        $pdf->Text(105, 25, "Total Laps  :                                " . $users['totalLaps']);
        $pdf->Text(105, 30, "Best Event Lap  :                   " . $users['bestLapEvent']);
        $pdf->Text(105, 35, "Best Personnal Lap  :            " . $users['bestLap']);

        $pdf->Output($outputFile, 'F');
        $email = $request->email;

        $emailData = ['name' => "DigiOasis", 'data' => "Hello DigiOasis"];
        $user['to'] = $email;
        $user['from'] = "digioasis@barqaab.pk";
        Mail::send('mail', $emailData, function ($messages) use ($user, $outputFile) {
            $messages->to($user['to']);
            $messages->from($user['from']);
            $messages->subject('Template Email from DigiOasis');
            $messages->attach($outputFile);
        });

        return response()->json(['message' => "Email Send Sucessfully."]);
    }
}
