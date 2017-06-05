@extends('app')
@section('content')
    <h1>Customer </h1>

    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
            <tr class="bg-info">
            <tr>
                <td>Name</td>
                <td><?php echo ($customer['name']); ?></td>
            </tr>
            <tr>
                <td>Cust Number</td>
                <td><?php echo ($customer['cust_number']); ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo ($customer['address']); ?></td>
            </tr>
            <tr>
                <td>City </td>
                <td><?php echo ($customer['city']); ?></td>
            </tr>
            <tr>
                <td>State</td>
                <td><?php echo ($customer['state']); ?></td>
            </tr>
            <tr>
                <td>Zip </td>
                <td><?php echo ($customer['zip']); ?></td>
            </tr>
            <tr>
                <td>Home Phone</td>
                <td><?php echo ($customer['home_phone']); ?></td>
            </tr>
            <tr>
                <td>Cell Phone</td>
                <td><?php echo ($customer['cell_phone']); ?></td>
            </tr>


            </tbody>
        </table>
    </div>


    <?php
    $stockprice=null;
    $totalinitialstock= 0;
    $totalcurrentstock = 0;
    $totalinitialinvestment = 0;
    $totalcurrentinvestment = 0;
    $iportfolio = 0;
    $cportfolio = 0;
    ?>
    <br>
    <h2>Stocks </h2>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="bg-info">
                <th> Symbol </th>
                <th>Stock Name</th>
                <th>No. of Shares</th>
                <th>Purchase Price</th>
                <th>Purchase Date</th>
                <th>Original Value</th>
                <th>Current Price</th>
                <th>Current Value</th>
            </tr>
            </thead>

            <tbody>




            @foreach($customer->stocks as $stock)
                <tr>
                    <td>{{ $stock->symbol }}</td>
                    <td>{{ $stock->name }}</td>
                    <td>{{ $stock->shares }}</td>
                    <td>${{ $stock->purchase_price }}</td>
                    <td>{{ $stock->purchase_date }}</td>

                    <?php $StockValue = floatval($stock->purchase_price) * floatval($stock->shares);?>
                    <td>${{ $StockValue }}</td>
                    <?php   $totalinitialstock = $totalinitialstock + $StockValue;?>
                    <td>$
                        <?php

                        $ssymbol = $stock->symbol;
                        //echo "<br><br>";

                        //print "Stock Symbol is:  $ssymbol";
                        try
                        {
                        $URL = "http://www.google.com/finance/info?q=NSE:" . $ssymbol;


                         $file = fopen("$URL", "r");
                            $r = "";
                                 do {
                            $data = fread($file, 500);
                            $r .= $data;
                                } while (strlen($data) != 0);
                        //Remove CR's from ouput - make it one line
                        $json = str_replace("\n", "", $r);

                        //Remove //, [ and ] to build qualified string
                        $data = substr($json, 4, strlen($json) - 5);

                        //decode JSON data
                        $json_output = json_decode($data, true);
                        //echo $sstring, "<br>   ";

                        $price = "\n" . $json_output['l'];
                        } catch(Exception $e)
                            {
                                $price = 0;
                            }

                        //var_dump(json_decode($data));
                        //var_dump($price);
                        //echo "<br><br>";
                        //echo "Price in dollars delayed by 20 minutes $ ";

                        echo $price;
                        ?>



                        </td>
                    <?php $LatestStockValue =$price * floatval($stock->shares); ?>
                    <td>${{ $LatestStockValue }}</td>
                    <?php   $totalcurrentstock = $totalcurrentstock + $LatestStockValue;?>
                   </tr>

            @endforeach

            </tbody>
        </table>
        <h4>Total of Initial Stock Portfolio $<?php echo $totalinitialstock; ?></h4>
        <h4>Total of Current Stock Portfolio $<?php echo $totalcurrentstock; ?></h4>
    </div>

    <br>
    <h2>Investments </h2>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="bg-info">
                <th> Category </th>
                <th>Description</th>
                <th>Acquired Value</th>
                <th>Acquired Date</th>
                <th>Recent value</th>
                <th>Recent Date</th>
            </tr>
            </thead>

            <tbody>




            @foreach($customer->investments as $investment)
                <tr>
                    <td>{{ $investment->category }}</td>
                    <td>{{ $investment->description }}</td>
                    <td>{{ $investment->acquired_value }}</td>
                    <td>{{ $investment->acquired_date }}$</td>
                    <td>{{ $investment->recent_value }}</td>
                    <td>{{ $investment->recent_date }}</td>

               <?php $totalinitialinvestment= $totalinitialinvestment + $investment->acquired_value; ?>
               <?php $totalcurrentinvestment= $totalcurrentinvestment + $investment->recent_value; ?>
                </tr>
            @endforeach

            </tbody>
        </table>
        <h4>Total of Initial Investment Portfolio $<?php echo $totalinitialinvestment; ?></h4>
        <h4>Total of Current Investment Portfolio $<?php echo $totalcurrentinvestment; ?></h4>
    </div>

    <br>
    <h2>Summary of Portfolio </h2>
    <div class="container">
        <?php $iportfolio = $totalinitialstock + $totalinitialinvestment; ?>
        <?php $cportfolio = $totalcurrentstock + $totalcurrentinvestment; ?>
        <h4>Total of Initial Portfolio Value $<?php echo $iportfolio; ?></h4>
        <h4>Total of Current Portfolio Value $<?php echo $cportfolio; ?></h4>
    </div>


@stop


