<?php
/**
  * This file is part of consoletvs/invoices.
  *
  * (c) Erik Campobadal <soc@erik.cat>
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace ConsoleTVs\Invoices\Classes;

use Carbon\Carbon;
use ConsoleTVs\Invoices\Traits\Setters;
use Illuminate\Support\Collection;
use Storage;

/**
 * This is the Invoice class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Invoice
{
    use Setters;

    public $template;

    public $number = null;
    public $name;
    public $date;
    public $logo_file;
    public $logo_path;
    public $logo_height;

    public $business_details;
    public $customer_details;
    public $items;

    public $decimals;
    public $currency;
    public $discount;
    public $discount_price;
    public $subtotal;
    public $total;

    public $remarks;

    public $header;
    public $footer;

    private $pdf;


    public function __construct($name = 'Invoice')
    {
        $this->template = 'default';

        $this->name = $name;
        $this->date = Carbon::now();
        $this->logo_file = null;
        $this->logo_path = "";
        $this->logo_height = config('invoices.logo_height');

        $this->business_details = Collection::make([]);
        $this->customer_details = Collection::make([]);
        $this->items = Collection::make([]);

        $this->decimals = config('invoices.decimals');
        $this->currency = config('invoices.currency');
        $this->discount = config('invoices.discount');
        $this->discount_price = config('invoices.discount_price');
        $this->total = config('invoices.total');
        $this->subtotal = config('invoices.subtotal');

        $this->remarks = config('invoices.remarks');

        $this->header = config('invoices.header');
        $this->footer = config('invoices.footer');
    }


    public static function make($name = 'Invoice')
    {
        return new self($name);
    }

    public function template($template = 'default')
    {
        $this->template = $template;

        return $this;
    }

    public function addItem($name, $amount = 1, $subtotalPrice, $totalPrice)
    {
        $this->items->push(Collection::make([
            'name'          => $name,
            'amount'        => $amount,
            'subtotalPrice' => $subtotalPrice,
            'totalPrice'    => number_format($totalPrice, $this->decimals),
        ]));

        return $this;
    }

    public function formatCurrency()
    {
        $currencies = json_decode(file_get_contents(__DIR__.'/../Currencies.json'));
        $currency = $this->currency;

        return $currencies->$currency;
    }

    public function discountFormatted()
    {
        return number_format($this->discount, $this->decimals);
    }

    public function discountPriceFormatted()
    {
        return number_format($this->discount_price, $this->decimals);
    }

    public function subTotalPriceFormatted()
    {
        return number_format($this->subtotal, $this->decimals);
    }

    public function totalPriceFormatted()
    {
        return number_format($this->total, $this->decimals);
    }


    private function generate()
    {
        $this->pdf = PDF::generate($this, $this->template);

        return $this;
    }

    public function download($name = 'invoice')
    {
        $this->generate();

        return $this->pdf->stream($name);
    }

    public function save($name = 'invoice.pdf')
    {
        $invoice = $this->generate();

        Storage::put($name, $invoice->pdf->output());
    }

    public function show($name = 'invoice')
    {
        $this->generate();

        return $this->pdf->stream($name, ['Attachment' => false]);
    }

    public function getFile() {
        $invoice = $this->generate();
        return $invoice->pdf->output();
    }
}
