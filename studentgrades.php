<?php include("includes/header.php");
loggedin_only(); ?>

<div class="container mt-5">
    <h1 align="center" class="mb-5">Choose a grade</h1>
    <div class="row">
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
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#grade11OptionsModal">Add</a>
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
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#grade12OptionsModal">Add</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grade 11 Options Modal -->
<div class="modal fade" id="grade11OptionsModal" tabindex="-1" role="dialog" aria-labelledby="grade11OptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="grade11OptionsModalLabel">Select Option for Grade 11</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please select an option for Grade 11:</p>
                <a href="studentgradesadd.php?grade=11&option=neb" class="btn btn-primary">NEB</a>
                <a href="studentgradesadd.php?grade=11&option=alevels" class="btn btn-primary">A Levels</a>
            </div>
        </div>
    </div>
</div>

<!-- Grade 12 Options Modal -->
<div class="modal fade" id="grade12OptionsModal" tabindex="-1" role="dialog" aria-labelledby="grade12OptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="grade12OptionsModalLabel">Select Option for Grade 12</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please select an option for Grade 12:</p>
                <a href="studentgradesadd.php?grade=12&option=neb" class="btn btn-primary">NEB</a>
                <a href="studentgradesadd.php?grade=12&option=alevels" class="btn btn-primary">A Levels</a>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>