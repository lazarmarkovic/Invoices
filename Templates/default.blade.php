<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ $invoice->name }}</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            h1,h2,h3,h4,p,span,div { font-family: DejaVu Sans; }

            header {
                padding-top: 20px;
                padding-bottom: 20px;
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                color: black;
                text-align: center;
                line-height: 35px;
            }

            footer {
                margin-top: 20px;
                margin-bottom: 20px;
                position: fixed;
                bottom: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                color: black;
                text-align: center;
                line-height: 35px;
            }
        </style>
    </head>
    <body>
    <header>
        {{ $invoice->header }}
    </header>

    <footer>
        {{ $invoice->footer }}
    </footer>
    <main>
        <div style="clear:both; position:relative;">
            @if ($invoice->logo_path != "")
                <div style="position:absolute; left:0pt; width:250pt;">
                    <img class="img-rounded"
                         height="{{ $invoice->logo_height }}"
                         src="{{ 'data:image/' . explode('.', $invoice->logo_path)[1] . ';base64,' . base64_encode($invoice->logo_file) }}">
                </div>
            @endif
            <div style="margin-left:300pt;">
                <b>Date: </b> {{ $invoice->date->formatLocalized('%A %d %B %Y') }}<br />
                @if ($invoice->number)
                    <b>{{ $invoice->name }}</b> {{ $invoice->number ? '#' . $invoice->number : '' }}
                @endif
                <br />
            </div>
        </div>
        <br />
        <h2>{{ $invoice->name }} {{ $invoice->number ? '#' . $invoice->number : '' }}</h2>
        <div style="clear:both; position:relative;">
            <div style="position:absolute; left:0pt; width:250pt;">
                <h4>Business Details:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! $invoice->business_details->count() == 0 ? '<i>No business details</i><br />' : '' !!}
                        {{ $invoice->business_details->get('name') }}<br />
                        {{ $invoice->business_details->get('contact_person') }} <br />
                        ID: {{ $invoice->business_details->get('id') }}<br />
                        Phone: {{ $invoice->business_details->get('contact_phone') }}<br />
                        Email: {{ $invoice->business_details->get('email') }}<br />
                        {{ $invoice->business_details->get('street_address') }}<br />
                        {{ $invoice->business_details->get('postal_code') }} {{ $invoice->business_details->get('city') }} {{ $invoice->business_details->get('region') }}
                        {{ $invoice->business_details->get('country') }}<br />
                    </div>
                </div>
            </div>
            <div style="margin-left: 300pt;">
                <h4>Customer Details:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! $invoice->customer_details->count() == 0 ? '<i>No customer details</i><br />' : '' !!}
                        {{ $invoice->customer_details->get('name') }}<br />
                        {{ $invoice->customer_details->get('contact_person') }} <br />
                        ID: {{ $invoice->customer_details->get('id') }}<br />
                        Inquiry: {{ $invoice->customer_details->get('inquiry') }}<br />
                        Phone: {{ $invoice->customer_details->get('contact_phone') }}<br />
                        Email: {{ $invoice->customer_details->get('email') }}<br />
                        {{ $invoice->customer_details->get('street_address') }}<br />
                        {{ $invoice->customer_details->get('postal_code') }} {{ $invoice->customer_details->get('city') }} {{ $invoice->customer_details->get('region') }}
                        {{ $invoice->customer_details->get('country') }}<br />
                    </div>
                </div>
            </div>
        </div>
        <h4>Items:</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Drawing Nr.</th>
                <th>QTY</th>
                <th>Price / PC</th>
                <th>Final amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->get('name') }}</td>
                    <td>{{ $item->get('amount') }}</td>
                    <td>{{ $item->get('subtotalPrice') }} {{ $invoice->formatCurrency()->symbol }}</td>
                    <td>{{ $item->get('totalPrice') }} {{ $invoice->formatCurrency()->symbol }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="clear:both; position:relative;">
            <div style="margin-left: 5pt;">
                <h4>Total:</h4>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><b>Subtotal</b></td>
                        <td>{{ $invoice->subTotalPriceFormatted() }} {{ $invoice->formatCurrency()->symbol }}</td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Discount {{ '(' . $invoice->discountFormatted() . '%)' }}
                            </b>
                        </td>
                        <td>{{ $invoice->discountPriceFormatted() }} {{ $invoice->formatCurrency()->symbol }}</td>
                    </tr>
                    <tr>
                        <td><b>Total</b></td>
                        <td><b>{{ $invoice->totalPriceFormatted() }} {{ $invoice->formatCurrency()->symbol }}</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if($invoice->remarks)
            <div style="width:100%;">
                <h4>Remarks:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        @foreach(preg_split("/((\r?\n)|(\r\n?))/", $invoice->remarks) as $line)
                            <br>{{ $line }}
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </main>

    </body>
</html>
