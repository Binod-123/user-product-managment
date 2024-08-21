<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Bills</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-w" href="#"> User Product Management</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-md-auto gap-2">
        <li class="nav-item rounded">
          <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-house-fill me-2"></i>Home</a>
        </li>
        <li class="nav-item rounded">
          <a class="nav-link" href="#"><i class="bi bi-people-fill me-2"></i>Logout</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-3">
<a class="btn btn-success" style="margin-bottom:20px; align-item" href="/generate-bill" target="_blank">Generate Bill</a>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>S-no</th>
			<th>User Name</th>
			<th>Bill No</th>
			<th>Total Price</th>
			<th>Generated Date</th>
            <th>Action</th>
		</tr>
        <tbody>
		<tr>
			<td>1</td>
			<td>Alphabet puzzle</td>
			<td>2016/01/15</td>
			<td>Done</td>
			<td data-order="1000">€1.000,00</td>
		</tr>
</tbody>
	</thead>
</table>
</div>
<footer class="bg-dark text-white" style="position: absolute; bottom:0px; width:100%;">
  <p class="text-center p-4 m-0">Footer Content</p>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
  // DataTable initialisation
  $('#example').DataTable({
    "paging": true,
    "autoWidth": true,
    "columnDefs": [{
      "targets": 3,
      "createdCell": function(td, cellData, rowData, row, col) {
        if (cellData == 'Planned') {
          var rowIndex = row+1;
          $($('#example tbody tr:nth-child('+rowIndex+')')).addClass('greenStriped');
        }
      }
    }]
  });
});
</script>
</body>
</html>
