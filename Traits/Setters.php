<?php
/**
  * This file is part of consoletvs/invoices.
  *
  * (c) Erik Campobadal <soc@erik.cat>
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace ConsoleTVs\Invoices\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * This is the Setters trait.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
trait Setters
{
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function number($number)
    {
        $this->number = $number;

        return $this;
    }

    public function decimals($decimals)
    {
        $this->decimals = $decimals;

        return $this;
    }

    public function discount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    public function discountPrice($discount_price)
    {
        $this->discount_price = $discount_price;

        return $this;
    }

    public function subtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function total($total)
    {
        $this->total = $total;

        return $this;
    }

    public function logoFile($logo_file)
    {
        $this->logo_file = $logo_file;

        return $this;
    }

    public function logoPath($logo_path)
    {
        $this->logo_path = $logo_path;

        return $this;
    }

    public function logoHeight($logo_height)
    {
        $this->logo_height = $logo_height;

        return $this;
    }


    public function date(Carbon $date)
    {
        $this->date = $date;

        return $this;
    }

    public function remarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function business($details)
    {
        $this->business_details = Collection::make($details);

        return $this;
    }

    public function customer($details)
    {
        $this->customer_details = Collection::make($details);

        return $this;
    }

    public function currency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function header($header)
    {
        $this->header = $header;

        return $this;
    }

    public function footer($footer)
    {
        $this->footer = $footer;

        return $this;
    }
}
