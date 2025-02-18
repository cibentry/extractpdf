<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Policy PDF Extraction</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Upload Insurance Policy PDF and Extract Data</h2>
        <form id="pdfForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pdf_file">Upload PDF File</label>
                <input type="file" class="form-control" id="pdf_file" name="pdf_file" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload and Extract</button>
        </form>

        <div id="output" class="mt-5">
            <h4>Extracted Data</h4>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="policy_no">Policy No</label>
                <input type="text" id="policy_no" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="vehicle_no">Vehicle No</label>
                <input type="text" id="vehicle_no" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="engine_no">Engine No</label>
                <input type="text" id="engine_no" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="chassis_no">Chassis No</label>
                <input type="text" id="chassis_no" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="rto">RTO</label>
                <input type="text" id="rto" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="mfg_year">Manufacturing Year</label>
                <input type="text" id="mfg_year" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="gvw_or_cc">GVW / CC</label>
                <input type="text" id="gvw_or_cc" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="seating_capacity">Seating Capacity</label>
                <input type="text" id="seating_capacity" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="own_damage_premium">Total Own Damage Premium</label>
                <input type="text" id="own_damage_premium" class="form-control" readonly>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pdfForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: 'check_pdf.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var data = JSON.parse(response);

                        // Populate the extracted data into the textboxes
                        $('#name').val(data.name);
                        $('#policy_no').val(data.policy_no);
                        $('#vehicle_no').val(data.vehicle_no);
                        $('#engine_no').val(data.engine_no);
                        $('#chassis_no').val(data.chassis_no);
                        $('#rto').val(data.rto);
                        $('#mfg_year').val(data.mfg_year);
                        $('#gvw_or_cc').val(data.gvw_or_cc);
                        $('#seating_capacity').val(data.seating_capacity);
                        $('#own_damage_premium').val(data.own_damage_premium);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>
