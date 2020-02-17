<?php

use Illuminate\Database\Seeder;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use App\System\UnitMeasure;
use App\System\KardexMotif;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        $website = new Website;
        $website->uuid = 'dbclient';
        $website->managed_by_database_connection = 'client1';
        app(WebsiteRepository::class)->create($website);
        $hostname = new Hostname;
        $hostname->fqdn = 'client1.erpbackend.com.devel';
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        //$hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
        //$website   = app(\Hyn\Tenancy\Environment::class)->website();
        
        $unitMeasure = new UnitMeasure();
        $unitMeasure->idOfficial = 'AA1';
        $unitMeasure->name = 'Unidades';
        $unitMeasure->abbreviation = 'UNI';
        $unitMeasure->indActivated = 0;
        $unitMeasure->save();
        
        $kardexMotif = new KardexMotif();
        $kardexMotif->type = 'I';
        $kardexMotif->name = 'Compras';
        $kardexMotif->save();
        
        $kardexMotif = new KardexMotif();
        $kardexMotif->type = 'S';
        $kardexMotif->name = 'Consumo';
        $kardexMotif->save();
    }
}
