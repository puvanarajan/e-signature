<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <style>
        body {
            position: relative;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .signature {
            position: absolute;
        }
    </style>
</head>
<body>
    <!-- Embed the PDF content -->
    <embed src="{{ $documentPath }}" type="application/pdf" width="100%" height="600">


{{--        <div class="signature" style="top: {{ $y }}px; left: {{ $x }}px;">--}}
{{--            <img src="{{ storage_path('app/' . $signature) }}" alt="Signature" style="width: 100px;">--}}
{{--        </div>--}}

</body>
</html>
