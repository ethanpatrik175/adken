<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Order Reciept</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
   }
  </style>
    </head>
    <body>
        <div class="account-pages pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="elementBricka display" style="page-break-after:always">
                        <img src="data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAK8AAABOCAYAAABWikZSAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NTc3MiwgMjAxNC8wMS8xMy0xOTo0NDowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDowMTgwMTE3NDA3MjA2ODExOERCQjhGNzExQzI0RkZBQiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo2MEFFRTZGNTI3QUYxMUVBOENGQzlBQjY2NkI0MjYyNiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo2MEFFRTZGNDI3QUYxMUVBOENGQzlBQjY2NkI0MjYyNiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjA4Qzg1QjQ4QjIyMkVBMTE5Q0E4OEQ0RTgyRTkyMTUwIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDkxNzc1NDgtOGU2MS0xMWU5LTgwMjgtZTcwOTY3ZTJhMDIx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" style="display:block !important;" />
                        <hr />
                    </div>
                    <div class="col-sm-12 customer mb-3">
                        {!! $customer !!}
                    </div>
                    <div class="col-sm-12 mt-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty.</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody class="reciept-items">
                                {!! $invoiceItems !!}
                            </tbody>
                        </table>
                        <div class="calculation">
                            {!! $calculation !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
