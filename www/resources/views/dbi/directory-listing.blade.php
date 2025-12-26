<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
    <title>Index of {{ $displayPath }}</title>
</head>
<body>
<h1>Index of {{ $displayPath }}</h1>
<table>
    <tr>
        <th valign="top">&nbsp;</th>
        <th>Name</th>
        <th>Last modified</th>
        <th>Size</th>
        <th>&nbsp;</th>
    </tr>
    <tr><th colspan="5"><hr></th></tr>

    @if($parentUrl)
        <tr>
            <td valign="top">&nbsp;</td>
            <td><a href="{{ $parentUrl }}">Parent Directory</a></td>
            <td>&nbsp;</td>
            <td align="right">  - </td>
            <td>&nbsp;</td>
        </tr>
    @endif

    @foreach($directories as $directory)
        <tr>
            <td valign="top">&nbsp;</td>
            @if($isDBI)
                <td><a href="{{ rawurlencode($directory['name']) }}/">{{ e($directory['name']) }}/</a></td>
            @else
                <td><a href="{{ $baseUrl }}/{{ $currentPath ? $currentPath . '/' : '' }}{{ rawurlencode($directory['name']) }}">{{ e($directory['name']) }}/</a></td>
            @endif
            <td align="right">{{ date('d-M-Y H:i', $directory['mtime']) }}  </td>
            <td align="right">  - </td>
            <td>&nbsp;</td>
        </tr>
    @endforeach

    @foreach($files as $file)
        <tr>
            <td valign="top">&nbsp;</td>
            @if($isDBI)
                <td><a href="{{ rawurlencode($file['name']) }}">{{ e($file['name']) }}</a></td>
            @else
                <td><a href="{{ $baseUrl }}/{{ $currentPath ? $currentPath . '/' : '' }}{{ rawurlencode($file['name']) }}">{{ e($file['name']) }}</a></td>
            @endif
            <td align="right">{{ date('d-M-Y H:i', $file['mtime']) }}  </td>
            <td align="right">{{ \App\Helpers\FileSize::format($file['size']) }}</td>
            <td>&nbsp;</td>
        </tr>
    @endforeach

    <tr><th colspan="5"><hr></th></tr>
</table>
</body>
</html>
