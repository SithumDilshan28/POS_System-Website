<?php include 'db_connect.php'
?>

<style>
    span.float-right.summary_icon {
        font-size: 3rem;
        position: absolute;
        right: 1rem;
        top: 0;
    }

    .imgs {
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }

    .imgs img {
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }

    #imagesCarousel,
    #imagesCarousel .carousel-inner,
    #imagesCarousel .carousel-item {
        height: 60vh !important;
        background: black;
    }

    #imagesCarousel .carousel-item.active {
        display: flex !important;
    }

    #imagesCarousel .carousel-item-next {
        display: flex !important;
    }

    #imagesCarousel .carousel-item img {
        margin: auto;
    }

    #imagesCarousel img {
        width: auto !important;
        height: auto !important;
        max-height: calc(100%) !important;
        max-width: calc(100%) !important;
    }
</style>
<?php
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
$tot_sale = $result->num_rows;


$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
$categories = $result->num_rows;


$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = $result->num_rows;


?>


<div class="containe-fluid mt-5">
    <div class="row ml-3 mr-3 ">
         <div class="col-lg-12">
            <div class="">
                <div class="card-body text-center">
                    <h5 class="mb-2">
                    <?php
                date_default_timezone_set('Asia/Dhaka');
                $time = date('Hi');
                if (($time >= "0600") && ($time <= "1200")) {
                    echo "Good Morning " . $_SESSION['login_name'] . " !";
                } elseif (($time >= "1201") && ($time <= "1600")) {
                    echo "Good Afternoon ". $_SESSION['login_name'] . " !";
                } elseif (($time >= "1601") && ($time <= "2100")) {
                    echo "Good Evening ". $_SESSION['login_name'] . " !";
                } elseif (($time >= "2101") && ($time <= "2400")) {
                    echo "Good Night ". $_SESSION['login_name'] . " !";
                } else {
                    echo "Good Morning " . $_SESSION['login_name'] . " !";
                }
                ?>   </h5>
                    
                    
                </div>
            </div>      			
        </div> 
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card bg-secondary border-0 circle-primary theme-circle opacity-25">
                        <div class="card-body">
                            <h4 class="text-light font-weight-bold">Category</h4>
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <span class="text-light mr-3 font-weight-bold">
                                        <h3 class="font-weight-bold"><?php echo $categories; ?></h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark border-0 circle-secondary theme-circle opacity-25">
                        <div class="card-body">
                            <h4 class="text-light font-weight-bold">Orders</h4>
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <span class="text-light mr-3">
                                        <h3 class="font-weight-bold"><?php echo $tot_sale; ?> </h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-secondary border-0 circle-success theme-circle opacity-25">
                        <div class="card-body">
                            <h4 class="text-light font-weight-bold">Product</h4>
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <span class="text-light mr-3">
                                        <h3 class="font-weight-bold"><?php echo $products; ?></h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Panel -->
        <div class="col-md-12 mb-5 mt-4">
            <div class="card">
                <div class="card-header">
                    <h5>List of Orders </h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $order = $conn->query("SELECT * FROM orders order by unix_timestamp(date_created) desc ");
                            while ($row = $order->fetch_assoc()) :
                            ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td>
                                        <p> <?php echo date("M d,Y", strtotime($row['date_created'])) ?></p>
                                    </td>
                                    <td>
                                        <p> <?php echo $row['amount_tendered'] > 0 ? $row['ref_no'] : 'N/A' ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $row['customer_name'] ?></p>
                                    </td>
                                    <td>
                                        <p> <?php echo number_format($row['total_amount']) ?></p>
                                    </td>
                                    <td>
                                        <?php if ($row['amount_tendered'] > 0) : ?>
                                            <span class="badge badge-success">Paid</span>
                                        <?php else : ?>
                                            <span class="badge badge-primary">Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Table Panel -->
    </div>
</div>

<script>
    $('#manage-records').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                resp = JSON.parse(resp)
                if (resp.status == 1) {
                    alert_toast("Data successfully saved", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 800)

                }

            }
        })
    })
    $('#tracking_id').on('keypress', function(e) {
        if (e.which == 13) {
            get_person()
        }
    })
    $('#check').on('click', function(e) {
        get_person()
    })

    function get_person() {
        start_load()
        $.ajax({
            url: 'ajax.php?action=get_pdetails',
            method: "POST",
            data: {
                tracking_id: $('#tracking_id').val()
            },
            success: function(resp) {
                if (resp) {
                    resp = JSON.parse(resp)
                    if (resp.status == 1) {
                        $('#name').html(resp.name)
                        $('#address').html(resp.address)
                        $('[name="person_id"]').val(resp.id)
                        $('#details').show()
                        end_load()

                    } else if (resp.status == 2) {
                        alert_toast("Unknow tracking id.", 'danger');
                        end_load();
                    }
                }
            }
        })
    }
    $('table').dataTable()
</script>