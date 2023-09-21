<!DOCTYPE html>
<html lang="en-EN">
<?php
require __DIR__.DIRECTORY_SEPARATOR.'mysqli.php';

$r_p_page = 5;
$st_page = $_GET['values'] ?? 5;
$st_page = filter_var($st_page, FILTER_VALIDATE_INT);

$sql = 'SELECT COUNT(*) as total FROM `name_stu`';
$countall = $connect->query($sql);
$rowcount = $countall->fetch_object();
$rowcount = filter_var($rowcount->total, FILTER_VALIDATE_INT);

$__page = ceil($rowcount / 5);
$start_loop = $st_page / 5;
$last_val = ($__page - 1) * 5;
$start_SH = $start_loop + 4;
$last_page = $last_val / 5;
$page_start_position = (($start_loop - 1) * 5) + 1;
$page_end_position = ($start_loop * 5);
?>
 <head>
  <title>Page <?php echo $start_loop; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <style>
  a {
   font-weight:bold;
  }
  </style>
 </head>
 <body>
  <div class="container">
   <h3 align="center">Page <?php echo $start_loop; ?></h3>
   <div class="table-responsive">
    <table class="table table-responsive table-bordered table-striped caption-top">
    <caption class="text-center"><?php printf('Displaying %s to %s students', $page_start_position, $page_end_position); ?></caption>
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
    </tr>
  </thead>
  <tbody>
     <?php
$sql = "SELECT * FROM `name_stu` ORDER BY student_id LIMIT $st_page, $r_p_page";
$result = $connect->query($sql);

while ($row = $result->fetch_assoc()) {
    ?>
<tr>
      <th scope="row"><?php echo $row['student_id']; ?> </th>
      <td><?php echo $row['student_name']; ?></td>
      <td><?php echo $row['student_phone']; ?></td>
    </tr>
     <?php
}
?>
</tbody>
<tfoot>
<tr>
  <td class="offset-3" colspan="3"><p class="m-0 text-center"><?php printf('Database contains %d students', $rowcount); ?></p></td>
</tr>
</tfoot>
    </table>
    <div align="center">
<?php
if ($__page - 1 <= $start_SH) {
    $end_loop = $__page;
} else {
    $end_loop = $start_SH;
}
?>


<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
<?php
if ($st_page > 5) {
    $vars = ['page' => 1, 'values' => 5];
    $querystring = http_build_query($vars);
    printf('<li class="page-item"><a class="page-link" href="pagination.php?%s">First</a></li>', $querystring);
    printf('<li class="page-item"><a class="page-link" href="pagination.php?values=%d">&laquo;</a></li>', $st_page - 5);
}

for ($i = $start_loop; $i < $end_loop; ++$i) {
    $hide_values = $i * 5;
    $currentStyle = ($st_page !== $hide_values) ? 'inactive' : 'active';
    $vars = ['page' => ceil($i), 'values' => $hide_values];
    $querystring = http_build_query($vars);
    printf('<li class="page-item %s"><a class="page-link" href="pagination.php?%s">%d</a></li>', $currentStyle, $querystring, ceil($i));
}

if ($__page - 1 != $start_loop) {
    $vars = ['page' => $last_page, 'values' => $last_val];
    $querystring = http_build_query($vars);
    printf('<li class="page-item"><a class="page-link" href="pagination.php?values=%d">&raquo;</a></li>', $st_page + 5);
    printf('<li class="page-item"><a class="page-link" href="pagination.php?%s">Last</a></li>', $querystring);
}
?>
  </ul>
</nav>

    </div>
   </div>
  </div>
 </body>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>


