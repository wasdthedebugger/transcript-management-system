<?php include("includes/header.php");
loggedin_only(); ?>

<div class="container mt-5">
    <h1 align="center" class="mb-5">Choose a grade</h1>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <h3>SAT</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Add SAT scores</p>
                    <a href="studentgradesadd.php?grade=sat" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <h3>Grade 9</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Add your grades for grade 9.</p>
                    <a href="studentgradesadd.php?grade=9" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <h3>Grade 10</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Add your grades for grade 10.</p>
                    <a href="studentgradesadd.php?grade=10" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <h3>Grade 11</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Add your grades for grade 11.</p>
                    <a href="studentgradesadd.php?grade=11&system=neb" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <h3>Grade 12</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Add your grades for grade 12.</p>
                    <a href="studentgradesadd.php?grade=12&system=neb" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <h3>A Levels</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Add your grades for aggregate A-Levels.</p>
                    <a href="studentgradesadd.php?grade=aggregatealevels" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>