<!-- grade9.php -->


    <div class="row justify-content-center">
      <div class="col-md-10">
        <h2 class="text-center mb-4">Grade 9 Form</h2>


          <form action="process_grade9.php" method="POST">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Roll Number</th>
                    <th>Subject 1</th>
                    <th>Subject 2</th>
                    <th>Subject 3</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($roll_nos as $roll_no): ?>
                    <tr>
                      <td><?php echo $roll_no['roll_no']; ?></td>
                      <td><input type="text" name="grades_subject1[]" class="form-control" required></td>
                      <td><input type="text" name="grades_subject2[]" class="form-control" required></td>
                      <td><input type="text" name="grades_subject3[]" class="form-control" required></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit Grades</button>
            </div>
          </form>
        </div>

    </div>


