<div class="container mt-5">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Statistics</h3>
      <hr>
      <div class="row">
        <div class="col">
          <h4>Total Students</h4>
          <p class="card-text"><?php echo getTotalStudents($conn); ?></p>
        </div>
        <div class="col">
          <h4>Passed Students</h4>
          <p class="card-text"><?php echo getPassedStudents($conn); ?></p>
        </div>
        <div class="col">
          <h4>Failed Students</h4>
          <p class="card-text"><?php echo getFailedStudents($conn); ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
