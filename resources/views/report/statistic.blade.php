<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistic</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" media="all" />
    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


</style>
</head>
<body>
    <h1 class="text-center" style="text-align:center">Handprint School {{ $year }} Statistic</h1>
    <p class="text-center" style="text-align:center">Total Students from January to December</p>
    <table style="width:100%">
  <tr>
    <th>Month</th>
    <th>Students</th>
  </tr>
  @foreach ($data["data"] as $rec)
  <tr>
    <td>
    {{ $rec['month_name']}}
    </td>
    <td>
    {{ $rec['studies_count']}}
    </td>
  </tr>
@endforeach
<tr>
<td colspan="2" style="text-align:right"><b>Total Students: {{$student_count}}</b></td>
</tr>
</table>
<p style="text-align:right;margin-top:16px">
{{ date('Y-m-d H:i:s') }}
</p>

</body>
</html>
