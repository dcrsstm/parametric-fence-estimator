<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrototypeController extends Controller
{
    public function calculate(Request $request)
    {
        // Validate user inputs
        $validated = $request->validate([
            'length' => 'required|numeric|gt:0',
            'height' => 'required|numeric|gt:0',
            'thickness' => 'required|numeric|gt:0',
        ]);
        

        // 1. Get scalar inputs from form
        $length = floatval($request->input('length'));
        $height = floatval($request->input('height'));
        $thickness = floatval($request->input('thickness'));

        // 2. Hardcoded Constants & Unit Prices
        $constants = [
            'chb_per_sqm' => 12.5,
            'cement_bags_per_cum' => 9.0, // Class A mix
            'sand_cum_per_cum' => 0.5,
            'gravel_cum_per_cum' => 1.0,
            'waste_factor' => 1.05, // 5% waste allowance
            'daily_output_sqm' => 12.0, // DPWH labor output rate for CHB laying
        ];

        $unitPrices = [
            'cement' => 240.00,
            'sand' => 1500.00,
            'gravel' => 1600.00,
            'chb' => 18.00,
            'mason_rate' => 600.00,
            'laborer_rate' => 450.00,
        ];

        // 3. Compute Geometries
        $wallArea = $length * $height;
        $footingVolume = $length * $thickness * 0.30;

        // 4. Calculate Bill of Quantities (BOQ) with waste factor
        $totalCHB = ceil($wallArea * $constants['chb_per_sqm'] * $constants['waste_factor']);
        $totalCement = ceil($footingVolume * $constants['cement_bags_per_cum'] * $constants['waste_factor']);
        $totalSand = round($footingVolume * $constants['sand_cum_per_cum'] * $constants['waste_factor'], 2);
        $totalGravel = round($footingVolume * $constants['gravel_cum_per_cum'] * $constants['waste_factor'], 2);

        // 5. Handle Labor & Schedule (Automatic scaling vs Manual Overrides)
        if ($request->has('enable_custom')) {
            // Manual overrides from user inputs
            $masonsNeeded = intval($request->input('custom_masons', 1));
            $laborersNeeded = intval($request->input('custom_laborers', 1));
            
            if ($request->filled('custom_days')) {
                $estimatedDays = intval($request->input('custom_days'));
            } else {
                // Default calculation using custom crew size output rate
                $totalCrewOutput = ($constants['daily_output_sqm'] * $masonsNeeded);
                $estimatedDays = max(1, ceil($wallArea / $totalCrewOutput));
            }
        } else {
            // Automatic smart scaling based on project size
            if ($wallArea > 100) {
                $masonsNeeded = 3;
                $laborersNeeded = 4;
            } elseif ($wallArea > 50) {
                $masonsNeeded = 2;
                $laborersNeeded = 3;
            } else {
                $masonsNeeded = 1;
                $laborersNeeded = 2;
            }

            $totalCrewOutput = ($constants['daily_output_sqm'] * $masonsNeeded);
            $estimatedDays = max(1, ceil($wallArea / $totalCrewOutput));
        }

        // 6. Compute Costs
        $materialCost = ($totalCHB * $unitPrices['chb']) +
                        ($totalCement * $unitPrices['cement']) +
                        ($totalSand * $unitPrices['sand']) +
                        ($totalGravel * $unitPrices['gravel']);

        $laborCost = ($estimatedDays * $masonsNeeded * $unitPrices['mason_rate']) +
                     ($estimatedDays * $laborersNeeded * $unitPrices['laborer_rate']);

        $directCost = $materialCost + $laborCost;

        // DPWH D.O. 197 s. 2016 Indirect Markups
        $ocm = $directCost * 0.12;
        $profit = $directCost * 0.08;
        $vat = ($directCost + $ocm + $profit) * 0.12;
        $finalFee = $directCost + $ocm + $profit + $vat;

        // 7. Pass results to view
        return view('results', compact(
            'wallArea', 'totalCHB', 'totalCement', 'totalSand', 'totalGravel',
            'estimatedDays', 'masonsNeeded', 'laborersNeeded', 
            'materialCost', 'laborCost', 'directCost', 'ocm', 'profit', 'vat', 'finalFee'
        ));
    }
}