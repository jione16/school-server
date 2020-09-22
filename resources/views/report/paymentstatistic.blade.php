<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistic</title>
    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.text-center {
    text-align: center;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


</style>
</head>
<body>
    <h1 class="text-center" style="text-align:center">Handprint School {{ $year }} Earning</h1>
    <p class="text-center" style="text-align:center">Total Earn from January to December</p>
    <table style="width:100%">
  <tr>
    <th>Month</th>
    <th>Amount</th>
  </tr>
  @foreach ($data["data"] as $rec)
  <tr>
    <td>
    {{ $rec['month_name']}}
    </td>
    <td>
    {{ $rec['amount_sum'].'$'}}
    </td>
  </tr>
@endforeach
<tr>
<td colspan="2" style="text-align:right"><b>Total: {{$total_sum.'$'}}</b></td>
</tr>
</table>
<p style="text-align:right;margin-top:16px">
{{ date('Y-m-d H:i:s') }}
</p>

</body>
</html>
