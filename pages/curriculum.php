<?php
loggedin_only();
if (isset($_GET['status'])) {
  success("Updated Successfully");
}
?>

<div id="custom-ui">
  <div class="row">
    <div class="custom-card">
      <div class="card-header">
        <h3>SAT</h3>
      </div>
      <div class="card-body">
        <p class="card-text">Add SAT scores.</p>
        <a href="?page=studentgradesadd&grade=sat" class="custom-button">Add</a>
      </div>
    </div>
    <div class="custom-card">
      <div class="card-header">
        <h3>Grade 9</h3>
      </div>
      <div class="card-body">
        <p class="card-text">Add your grades for grade 9.</p>
        <a href="?page=studentgradesadd&grade=9" class="custom-button">Add</a>
      </div>
    </div>
    <div class="custom-card">
      <div class="card-header">
        <h3>Grade 10</h3>
      </div>
      <div class="card-body">
        <p class="card-text">Add your grades for grade 10.</p>
        <a href="?page=studentgradesadd&grade=10" class="custom-button">Add</a>
      </div>
    </div>
    <div class="custom-card">
      <div class="card-header">
        <h3>Grade 11</h3>
      </div>
      <div class="card-body">
        <p class="card-text">Add your grades for grade 11.</p>
        <a href="?page=studentgradesadd&grade=11&system=neb" class="custom-button">Add</a>
      </div>
    </div>
    <div class="custom-card">
      <div class="card-header">
        <h3>Grade 12</h3>
      </div>
      <div class="card-body">
        <p class="card-text">Add your grades for grade 12.</p>
        <a href="?page=studentgradesadd&grade=12&system=neb" class="custom-button">Add</a>
      </div>
    </div>
    <div class="custom-card">
      <div class="card-header">
        <h3>A Levels</h3>
      </div>
      <div class="card-body">
        <p class="card-text">Add your grades for aggregate A-Levels.</p>
        <a href="?page=studentgradesadd&grade=aggregatealevels" class="custom-button">Add</a>
      </div>
    </div>
  </div>
</div>

<style>
  #custom-ui .row {
    display: flex;
    flex-wrap: wrap;
    margin: 40px;
    gap: 40px;
    justify-content: center;
  }

  .custom-card {
    border: 1px solid #000;
    border-radius: 0;
    width: 100%;
    max-width: 400px;
  }

  .custom-card .card-header {
    background-color: #d6dfe8;
    padding: 10px;
    border-radius: 0;
  }

  .card-header h3 {
    margin: 0;
  }

  .custom-card .card-body {
    padding: 10px;
  }

  .custom-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #d6dfe8;
  }

  .custom-button:hover {
    background-color: #b3c0d1;
  }
</style>