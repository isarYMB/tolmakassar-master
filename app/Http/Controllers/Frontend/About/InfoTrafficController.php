<?php

namespace App\Http\Controllers\Frontend\About;

use App\Charts\Jtse\KomposisiGerbang as JtseKomposisiGerbang;
use App\Charts\Jtse\KomposisiGolongan as JtseKomposisiGolongan;
use App\Charts\Jtse\LaluLintasBulanan as JtseLaluLintasBulanan;
use App\Charts\Jtse\LaluLintasHarian as JtseLaluLintasHarian;
use App\Charts\Jtse\LaluLintasHarianGerbang as JtseLaluLintasHarianGerbang;
use App\Charts\Jtse\PerbandinganGerbang as JtsePerbandinganGerbang;
use App\Charts\Jtse\PerbandinganGolongan as JtsePerbandinganGolongan;
use App\Charts\Jtse\TrafficHistory as JtseTrafficHistory;
use Illuminate\Http\Request;
use App\Charts\Mmn\TrafficHistory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Charts\Mmn\KomposisiGerbang;
use App\Charts\Mmn\LaluLintasHarian;
use App\Charts\Mmn\KomposisiGolongan;
use App\Charts\Mmn\LaluLintasBulanan;
use App\Charts\Mmn\PerbandinganGerbang;
use App\Charts\Mmn\PerbandinganGolongan;
use App\Charts\Mmn\LaluLintasHarianGerbang;
use App\Models\info_traffic;
use Illuminate\Support\Arr;

class InfoTrafficController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $lastDate;
    protected $currentYear;
    protected $currentMonth;
    protected $currentMonthNumber;
    protected $currentMonthFullName;
    protected $prevYear;
    protected $prevMonth;
    protected $prevMonthNumber;
    protected $prevMonthFullName;
    protected $listMonth;


    public function __construct(info_traffic $info_traffic)
    {
        $this->lastDate = $info_traffic->queryLastDate();
        $this->currentYear = $info_traffic->getCurrentTime('year', $this->lastDate);
        $this->currentMonthNumber = $info_traffic->getCurrentTime('monthnumber', $this->lastDate);
        $this->currentMonthFullName = $info_traffic->getCurrentTime('monthfullname', $this->lastDate);
        $this->currentMonth = $info_traffic->getCurrentTime('month', $this->lastDate);

        $this->prevYear = $info_traffic->getPrevTime('year', $this->lastDate);
        $this->prevMonthNumber = $info_traffic->getPrevTime('monthnumber', $this->lastDate);
        $this->prevMonthFullName = $info_traffic->getPrevTime('monthfullname', $this->lastDate);
        $this->prevMonth = $info_traffic->getPrevTime('month', $this->lastDate);

        $this->listMonth = $info_traffic->listMonth($this->currentYear);


    }


    // LALU LINTAS HARIAN
    public function mmnHarian(LaluLintasHarian $chart)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 1
            'title' => 'Makassar Metro Network',
            'company' => 'MMN',
            'date' => $this->lastDate,
            'listMonth' => $this->listMonth,
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'chartTitle' => 'Laporan Lalu Lintas Harian',
            'chart' => $chart,
            'graph' => $chart->build($this->currentYear, $this->currentMonthNumber)
        ]);
    }
    public function mmnHarianBulan(LaluLintasHarian $chart, $bulan)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 1
            'title' => 'Makassar Metro Network',
            'date' => $this->lastDate,
            'company' => 'MMN',
            'listMonth' => $this->listMonth,
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $bulan,
            'currentMonthFullName' => date('F', mktime(0, 0, 0, $bulan)),
            'currentMonth' => date('M', mktime(0, 0, 0, $bulan)),
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $bulan - 1,
            'prevMonthFullName' => date('F', mktime(0, 0, 0, $bulan-1)),
            'prevMonth' => date('M', mktime(0, 0, 0, $bulan-1)),
            'chartTitle' => 'Laporan Lalu Lintas Harian',
            'chart' => $chart,
            'graph' => $chart->build($this->currentYear, $bulan)
        ]);
    }

    public function jtseHarian(JtseLaluLintasHarian $chart)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 1
            'title' => 'Jalan Tol Seksi Empat',
            'company' => 'JTSE',
            'date' => $this->lastDate,
            'listMonth' => $this->listMonth,
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'chartTitle' => 'Laporan Lalu Lintas Harian',
            'chart' => $chart,
            'graph' => $chart->build($this->currentYear, $this->currentMonthNumber)
        ]);
    }

    public function jtseHarianBulan(JtseLaluLintasHarian $chart, $bulan)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 1
            'title' => 'Jalan Tol Seksi Empat',
            'date' => $this->lastDate,
            'company' => 'JTSE',
            'listMonth' => $this->listMonth,
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $bulan,
            'currentMonthFullName' => date('F', mktime(0, 0, 0, $bulan)),
            'currentMonth' => date('M', mktime(0, 0, 0, $bulan)),
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $bulan - 1,
            'prevMonthFullName' => date('F', mktime(0, 0, 0, $bulan-1)),
            'prevMonth' => date('M', mktime(0, 0, 0, $bulan-1)),
            'chartTitle' => 'Laporan Lalu Lintas Harian',
            'chart' => $chart,
            'graph' => $chart->build($this->currentYear, $bulan)
        ]);
    }




    // LALU LINTAS GERBANG HARIAN
    public function mmnGerbang(LaluLintasHarianGerbang $chart2)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 2
            'title' => 'Makassar Metro Network',
            'date' => $this->lastDate,
            'gateList' => ['Cambaya', 'Parangloe', 'Kaluku-Bodoa', 'Tallo-Timur', 'Tallo-Barat'],
            'company' => 'MMN',
            'gate' => 'KALUKU BODOA',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph2' => $chart2->build($this->currentYear, $this->currentMonthNumber, 'KALUKU BODOA'),
            'chartTitle2' => 'Laporan Lalu Lintas Harian Gerbang',
            'chart2' => $chart2,
        ]);
    }

    public function mmnGerbangDetail(LaluLintasHarianGerbang $chart2, $gate)
    {
        $g = str_replace('-', ' ', strtoupper($gate));
        return view('frontend.pages.about-us.infoTraffic', [
            // section 2
            'title' => 'Makassar Metro Network',
            'date' => $this->lastDate,
            'gateList' => ['Cambaya', 'Parangloe', 'Kaluku-Bodoa', 'Tallo-Timur', 'Tallo-Barat'],
            'company' => 'MMN',
            'gate' => $g,
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph2' => $chart2->build($this->currentYear, $this->currentMonthNumber, $g),
            'chartTitle2' => 'Laporan Lalu Lintas Harian Gerbang',
            'chart2' => $chart2,
        ]);
    }

    public function jtseGerbang(JtseLaluLintasHarianGerbang $chart2)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 2
            'title' => 'Jalan Tol Seksi Empat',
            'date' => $this->lastDate,
            'gateList' => ['Tamalanrea', 'Biringkanaya', 'Parangloe-Ramp', 'Bira-Barat', 'Bira-Timur'],
            'company' => 'JTSE',
            'gate' => 'TAMALANREA',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph2' => $chart2->build($this->currentYear, $this->currentMonthNumber, 'TAMALANREA'),
            'chartTitle2' => 'Laporan Lalu Lintas Harian Gerbang',
            'chart2' => $chart2,
        ]);
    }

    public function jtseGerbangDetail(JtseLaluLintasHarianGerbang $chart2, $gate)
    {
        $g = str_replace('-', ' ', strtoupper($gate));
        return view('frontend.pages.about-us.infoTraffic', [
            // section 2
            'title' => 'Jalan Tol Seksi Empat',
            'date' => $this->lastDate,
            'gateList' => ['Tamalanrea', 'Biringkanaya', 'Parangloe-Ramp', 'Bira-Barat', 'Bira-Timur'],
            'company' => 'JTSE',
            'gate' => $g,
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph2' => $chart2->build($this->currentYear, $this->currentMonthNumber, $g),
            'chartTitle2' => 'Laporan Lalu Lintas Harian Gerbang',
            'chart2' => $chart2,
        ]);
    }



    // LALU LINTAS BULANAN
    public function mmnBulanan(LaluLintasBulanan $chart)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 3
            'title' => 'Makassar Metro Network',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph3' => $chart->build($this->currentYear),
            'chartTitle3' => 'Laporan Lalu Lintas Bulanan',
            'chart3' => $chart,
        ]);
    }
    public function jtseBulanan(JtseLaluLintasBulanan $chart)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 3
            'title' => 'Jalan Tol Seksi Empat',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph3' => $chart->build($this->currentYear),
            'chartTitle3' => 'Laporan Lalu Lintas Bulanan',
            'chart3' => $chart,
        ]);
    }



    // KOMPOSISI GERBANG DAN GOLONGAN
    public function mmnKomposisi(KomposisiGerbang $chart1, KomposisiGolongan $chart2, PerbandinganGerbang $chart3, PerbandinganGolongan $chart4)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 3
            'title' => 'Makassar Metro Network',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph4' => $chart1->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle4' => 'Komposisi Gerbang',
            'chart4' => $chart1,
            'graph5' => $chart2->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle5' => 'Komposisi Golongan',
            'chart5' => $chart2,
            'chart7' => $chart3->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle7' => 'Perbandingan Gerbang',
            'chart8' => $chart4->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle8' => 'Perbandingan Gerbang',
        ]);
    }
    public function jtseKomposisi(JtseKomposisiGerbang $chart1, JtseKomposisiGolongan $chart2, JtsePerbandinganGerbang $chart3, JtsePerbandinganGolongan $chart4)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section 3
            'title' => 'Jalan Tol Seksi Empat',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'graph4' => $chart1->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle4' => 'Komposisi Gerbang',
            'chart4' => $chart1,
            'graph5' => $chart2->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle5' => 'Komposisi Golongan',
            'chart5' => $chart2,
            'chart7' => $chart3->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle7' => 'Perbandingan Gerbang',
            'chart8' => $chart4->build($this->currentYear, $this->currentMonthNumber),
            'chartTitle8' => 'Perbandingan Gerbang',
        ]);
    }



    // TRAFFIC HISTORY
    public function mmnTrafficHistory(TrafficHistory $chart6)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section5
            'title' => 'Makassar Metro Network',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'chart6' => $chart6->build(),
            'chartTitle6' => 'Traffic History',
            'staticDescription' => $chart6->staticDescription(),
        ]);
    }
    public function jtseTrafficHistory(JtseTrafficHistory $chart6)
    {
        return view('frontend.pages.about-us.infoTraffic', [
            // section5
            'title' => 'Jalan Tol Seksi Empat',
            'currentYear' => $this->currentYear,
            'currentMonthNumber' => $this->currentMonthNumber,
            'currentMonthFullName' => $this->currentMonthFullName,
            'currentMonth' => $this->currentMonth,
            'prevYear' => $this->prevYear,
            'prevMonthNumber' => $this->prevMonthNumber,
            'prevMonthFullName' => $this->prevMonthFullName,
            'prevMonth' => $this->prevMonth,
            'chart6' => $chart6->build(),
            'chartTitle6' => 'Traffic History',
            'staticDescription' => $chart6->staticDescription(),
        ]);
    }

    // TESTING
    public function test()
    {
        return view('frontend.pages.about-us.test', [
            'title' => 'Info Traffic',
            'test' => 'ayyo',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
