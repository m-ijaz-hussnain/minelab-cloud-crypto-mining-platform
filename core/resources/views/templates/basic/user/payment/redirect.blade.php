<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ gs('site_name') }}</title>
</head>

<body>
    <form id="auto_submit" action="{{ $data->url }}" method="{{ $data->method }}">
        @foreach ($data->val as $k => $v)
            <input name="{{ $k }}" type="hidden" value="{{ $v }}" />
        @endforeach
    </form>
    <script>
        "use strict";
        document.getElementById("auto_submit").submit();
    </script>
</body>

</html>
