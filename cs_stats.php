<?php include 'db_connect.php' ?>

<div class="col-lg-12">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Daily CS Service Statistics</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="cs_stats">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>CS Name</th>
                        <th>Total Customers</th>
                        <th>Total Service Time (minutes)</th>
                        <th>Average Service Time per Customer (minutes)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qry = $conn->query("
                        SELECT DATE(t.time_begin) as service_date,
                               CONCAT(s.firstname, ' ', IFNULL(s.middlename, ''), ' ', s.lastname) as customer_service,
                               COUNT(DISTINCT t.id) as total_customers,
                               SUM(TIMESTAMPDIFF(MINUTE, t.time_begin, c.time_finished)) as total_service_time,
                               AVG(TIMESTAMPDIFF(MINUTE, t.time_begin, c.time_finished)) as avg_service_time
                        FROM tickets t
                        JOIN comments c ON t.id = c.ticket_id
                        JOIN staff s ON t.staff_id = s.id
                        WHERE s.role = 'Customer Service'
                        GROUP BY DATE(t.time_begin), s.id
                    ");

                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <tr>
                            <td><?php echo $row['service_date'] ?></td>
                            <td><?php echo $row['customer_service'] ?></td>
                            <td><?php echo $row['total_customers'] ?></td>
                            <td><?php echo $row['total_service_time'] ?></td>
                            <td><?php echo $row['avg_service_time'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cs_stats').dataTable();
    });
</script>
