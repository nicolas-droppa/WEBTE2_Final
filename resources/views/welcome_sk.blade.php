@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-16 mb-20 px-6">
        <h1 class="text-4xl font-bold mb-6 text-slate-800 dark:text-gray-100">Vitajte na stránke M3th!</h1>
        <p class="text-lg text-slate-600 dark:text-gray-300 mb-10">
            Objavte množstvo matematických úloh, cvičení a testov, ktoré vás posunú vpred.
        </p>

        <div class="bg-white dark:bg-[#1c1c1e] rounded-xl shadow-md p-8 space-y-8 border border-slate-200 dark:border-[#141414]">
            <h2 class="text-2xl font-semibold text-[#54b5ff] dark:text-[#54b5ff] border-b pb-2 dark:border-[#141414]">
                <i class="fas fa-compass mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                Návod na používanie aplikácie
            </h2>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-globe mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Prepínanie jazyka a témy vzhľadu
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    V hornej lište nájdete možnosť zmeniť jazyk aplikácie (<strong>SK / EN</strong>) a tiež si prepínať
                    <strong>svetlý/tmavý režim</strong> pomocou ikoniek.
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-question-circle mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Typy otázok v teste
                </h3>
                <ul class="list-disc list-inside text-slate-700 dark:text-gray-400 space-y-1">
                    <li>Výber z viacerých možností – len <strong>jedna správna odpoveď</strong>.</li>
                    <li>Otvorené otázky, kde zadávate <strong>číselnú odpoveď</strong>.</li>
                    <li>Čísla zapisujte s bodkou alebo čiarkou (<code>1.25</code> / <code>1,25</code>).</li>
                    <li>Odporúčané <strong>zaokrúhlenie na 2 desatinné miesta</strong>, ak nie je uvedené inak.</li>
                </ul>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-stopwatch mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Časový limit
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    Po zobrazení otázky sa okamžite <strong>spustí časovač</strong>. Otázky sa zobrazujú po jednej. Rýchlosť odpovedí je súčasťou hodnotenia.
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-unlock-alt mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Prístup bez registrácie
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    Test môžete vyplniť <strong>bez registrácie</strong>. Výsledky sa ukladajú anonymne spolu s informáciou o vašej polohe (mesto a štát).
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-chart-bar mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    Výsledky a odporúčania
                </h3>
                <ul class="list-disc list-inside text-slate-700 dark:text-gray-400 space-y-1">
                    <li>Zobrazíme správne aj nesprávne odpovede vrátane vysvetlení.</li>
                    <li>Dostanete <strong>odporúčanie na zopakovanie konkrétnej témy</strong>.</li>
                    <li>Porovnáte si <strong>čas riešenia s priemerom ostatných používateľov</strong>.</li>
                    <li>Výsledky si môžete <strong>stiahnuť ako PDF</strong> pre ďalšiu analýzu alebo tlač.</li>
                </ul>
            </section>

            <div class="pt-4">
                <p class="text-base text-slate-600 dark:text-gray-400">
                    Ste pripravení? <span class="font-semibold text-[#54b5ff] dark:text-[#54b5ff]">Začnite svoj matematický tréning teraz!</span>
                </p>
            </div>
        </div>
    </div>
@endsection
