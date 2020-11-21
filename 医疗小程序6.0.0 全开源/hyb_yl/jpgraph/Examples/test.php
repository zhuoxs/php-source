<?php // content="text/plain; charset=utf-8"
DEFINE("TTF_DIR", __DIR__ . "/fonts/truetype/");

require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_line.php');
require_once('jpgraph/jpgraph_bar.php');

function addPercent($aVal)
{
    return round($aVal) . '%';
}

$datay = array(6, 6.3, 5.7);

// Size of graph
$width = 600;
$height = 900;

// Set the basic parameters of the graph
$graph = new Graph($width, $height);
$graph->SetScale('textlin');

$top = 50;
$bottom = 30;
$left = 50;
$right = 30;

$graph->Set90AndMargin($left, $right, $top, $bottom);

// normal
//$graph->SetMargin($left, $right, $top, $bottom);

$graph->SetImgFormat('png', 100);
$graph->img->SetAntiAliasing();
$graph->img->SetQuality(100);

// Setup labels
$lbl = array("Dezember 2015", "Juni 2016", "Dezember 2016");
$graph->xaxis->SetFont(FF_DEFAULT, FS_NORMAL, 12);
$graph->yaxis->SetLabelFormatCallback('addPercent');
$graph->yaxis->SetFont(FF_DEFAULT, FS_NORMAL, 12);
$graph->yaxis->HideLine(true);

$graph->yaxis->SetTickPositions([0, 1, 2, 3, 4, 5, 6, 7], []);
$graph->ygrid->Show(true, false);
$graph->ygrid->SetFill(false);
$graph->yaxis->HideLine(true);
$graph->yaxis->HideTicks(true, true);

$graph->SetBox(false);


// Create a bar pot
$bplot = new BarPlot($datay);
$graph->Add($bplot);

$bplot->SetColor('deepskyblue4');
$bplot->SetLegend('Leerstandsquote am Periodenende');
$bplot->SetFillColor('deepskyblue4');
$bplot->SetWidth(0.25);
$bplot->SetYMin(0);

$graph->legend->SetPos(0, 0.999999, 'left', 'bottom');
$graph->legend->SetFont(FF_DEFAULT);
$graph->legend->SetLineWeight(2);

$graph->Stroke();
