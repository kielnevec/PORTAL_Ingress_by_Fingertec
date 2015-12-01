<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("dompdf/dompdf_config.inc.php");

//spl_autoload_register('DOMPDF_autoload');

class pdf_2 {

    function pdf_create($html, $filename, $stream = TRUE) {
        $dompdf = new DOMPDF();
        $dompdf->set_paper("A4");

        $dompdf->load_html($html);
        $dompdf->render();

        $canvas = $dompdf->get_canvas();
        // get height and width of page
        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // get font
        $font = Font_Metrics::get_font("helvetica", "normal");
        $txtHeight = Font_Metrics::get_font_height($font, 7);

        //draw line for signature manager
        $mnline = $h - 10 * $txtHeight - 24;
        $colormn = array(0, 0, 0);
        $canvas->line(100, $mnline, $w - 400, $mnline, $colormn, 1);

        //text for signature Requestor/HOD
        $textmn = "Requestor";
        $widthmn = Font_Metrics::get_text_width($textmn, $font, 12);
        $canvas->text($w - $widthmn - 400, $mnline, $textmn, $font, 12);


        // draw a line along the bottom
        $y = $h - 2 * $txtHeight - 24;
        $color = array(0, 0, 0);
        $canvas->line(16, $y, $w - 16, $y, $color, 1);

        //draw line for GM/Manager
        //$canvas->line(270, $mnline, $w - 240, $mnline, $colormn, 1);
        $canvas->line(360, $mnline, $w - 100, $mnline, $colormn, 1);
        $texthr = "Head Of Department";
        $widthhr = Font_Metrics::get_text_width($texthr, $font, 12);
        $canvas->text($w - $widthmn - 160, $mnline, $texthr, $font, 12);

        // set page number on the left side
        //$canvas->page_text(16, $y, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, $color);

        $canvas->page_text($w - 324, $y, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, $color);

        // set additional text
        $text = "ESRNL PORTAL";
        $width = Font_Metrics::get_text_width($text, $font, 8);
        $canvas->text($w - $width - 16, $y, $text, $font, 8);

        if ($stream) {
            $dompdf->stream($filename . ".pdf");
        } else {
            $CI = & get_instance();
            $CI->load->helper('file');
            write_file($filename, $dompdf->output());
        }
    }

}

?>