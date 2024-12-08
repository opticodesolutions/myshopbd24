
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>My SHOP BD24.COM</title>
    <link rel="stylesheet" href="https://happyproductsltd.com/member/assets/css/invoice.css" media="all" />
    <link rel="shortcut icon" href="" type="image/x-icon">
</head>
<!---<body onload="window.print()">---->

<body>
    <header class="clearfix">
        <div id="logo">
            <a href="index.php"><img src=""></a>
        </div>
        <div id="company">
            <h2 class="name">Futuregroup.My.Com</h2>
            <div>Sherpur, Mymensingh.</div>
            <div></div>
            <div><a href="mailto: info@happyproductsltd.com">info@mybdshop24.com</a></div>
        </div>
        </div>
    </header>


    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">INVOICE TO:</div>
                <h2 class="name">Name: {{ auth()->user()->name }}</h2>
                <div class="email">User: {{ auth()->user()->email }}</div>
                <div class="address"></div>
            </div>
            <div id="invoice">
                <h1>INVOICE 171542266918811880</h1>
                <div class="date">Paid By (Purchase Balance)</div>
                <div class="date">Date of Invoice: {{ $purchase->created_at->format('d-M-Y h:i A') }}</div>
            </div>
        </div>



      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="no">01</td>
            <td class="desc"><h3>{{$purchase->product->name}}</h3></td>
            <td class="qty">1</td>
            <td class="total">৳ {{$purchase->product->price}}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">SUBTOTAL</td>
            <td>৳ {{$purchase->product->price}}</td>
          </tr>
          <tr>
            <td colspan="3">PAID</td>
            <td>৳ {{$purchase->product->price}}</td>
          </tr>
          <tr>
            <td colspan="3">DUE</td>
            <td>৳ 00</td>
          </tr>
        </tfoot>
      </table>


      <div style="display: flex;align-items: center;justify-content: center; margin-bottom: 10px;">
        <img src="https://happyproductsltd.com/image/static/paid.png" style="width: 130px;height: auto;">
      </div>



        <div id="thanks">Thank you! To be with us</div>
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">You have to receive product within 7 days.</div>
        </div>
    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>
