<?php 

/*
https://github.com/tecnickcom/TCPDF.git
*/


require_once('PDFGenerator/tcpdf.php');
$pdf = initialize();
$pdf->AddPage();

$teacher = $_GET['teacher'];
$subject = $_GET['subject'];
$schoolclass= $_GET['schoolClass'];
$theme = $_GET['theme'];
$goals = $_GET['goals'];
$didactics = $_GET['didactics'];
$connections = $_GET['relationships'];
$sources = $_GET['sources'];
$date = $_GET['date'];

$html = generateTable($teacher, $subject, $schoolclass, $theme, $goals, $didactics, $connections, $sources, $date);
 
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = generateLessonPlan($pdf);

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document
$pdf->Output('oraterv_'.$subject.'_'.$date.'.pdf', 'I');

function generateTable($teacher, $subject, $schoolclass, $theme, $goals, $didactics, $connections, $sources, $date){
    $htmlGen = '
    <h1 style="text-align: center; font-size: 30px;">Óraterv</h1>
    <h3 style="text-align: center;">'.$date.'</h3>
    <table border="1" style="line-height: 1.5;"  cellpadding="3">
        <tr>
            <td width="240">A pedagógus neve:</td>
            <td width="660">'.$teacher.'</td>
        </tr>
        <tr>
            <td>Tantárgy:</td>
            <td>'.$subject.'</td>
        </tr>
        <tr>
            <td>Osztály:</td>
            <td>'.$schoolclass.'</td>
        </tr>
        <tr>
            <td>Az óra témája:</td>
            <td>'.$theme.'</td>
        </tr>
        <tr>
            <td>Az óra cél- és feladatrendszere:</td>
            <td>'.$goals.'</td>
        </tr>
        <tr>
            <td>Az óra didaktikai feladatai:</td>
            <td>'.$didactics.'</td>
        </tr>
        <tr>
            <td>Tantárgyi kapcsolatok:</td>
            <td>'.$connections.'</td>
        </tr>
        <tr>
            <td>Felhasznált források:</td>
            <td>'.$sources.'</td>
        </tr>
        <tr>
            <td>Dátum:</td>
            <td>'.$date.'</td>
        </tr>
    </table>';

    return $htmlGen;
}

function generateLessonPlan($pdf){
    
    $LP = '
    <table border="1" style="line-height: 1.5;" >
    <thead>
        <tr style="text-align: center; line-height: 2; font-weight: bold;">
            <td width="50" style="line-height: 1.2;"><br><br>Idő<br>(perc)</td>
            <td width="255" style="line-height: 5;">Az óra menete</td>
            <td width="130" style="line-height: 5;">Módszerek</td>
            <td width="130" style="line-height: 1.2;"><br><br>Tanulói<br>munkaformák</td>
            <td width="130" style="line-height: 5;">Eszközök</td>
            <td width="250" style="line-height: 5;">Megjegyzések</td>
        </tr>
    </thead>
    ';

    $con = mysqli_connect('localhost', 'root', '');
    if(!$con) {die('Not Connected To Server'); }
    if(!mysqli_select_db($con, 'lessonplaner')) {echo 'Database Not Selected';}
    $con->set_charset('utf8');
    $sql="SELECT * FROM actual_activities";
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {

      $LP = $LP.'
      <tr style="line-height: 1.5;">
          <td width="50" style="text-align: center;">'.$row['time'].'</td>
          <td width="255">'.$row['lesson'].'</td>
          <td width="130">'.$row['method'].'</td>
          <td width="130">'.$row['workforms'].'</td>
          <td width="130">'.$row['tools'].'</td>
          <td width="250">'.$row['notes'].'</td>
      </tr>';
    }

    $sql = 'DELETE FROM actual_activities;';
    $result = mysqli_query($con,$sql);
    mysqli_close($con);

    return $LP."</table>";
}

function initialize(){
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('cyrio.hu');
    $pdf->SetTitle('Óratervem');
    $pdf->setPageOrientation('L');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    //$pdf->SetFont('times','',12);
    $pdf->SetFont('freeserif', '', 12);

    return $pdf;
}

?>