@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-20 px-4 text-center">
        <h1 class="text-4xl font-bold mb-6 dark:text-white">Vitajte na matematickej stránke!</h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-10">
            Objavte množstvo matematických úloh, cvičení a testov, ktoré vás posunú vpred.
        </p>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-8 text-left space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Návod na používanie aplikácie</h2>

            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">🗺️ Prepínanie jazyka a témy vzhľadu</h3>
                    <p class="text-gray-700 dark:text-gray-400">
                        V hornej lište (navbar) nájdete možnosť zmeniť jazyk aplikácie (napr. Slovensky / English).
                        Rovnako si môžete prepínať medzi svetlým a tmavým vzhľadom (light/dark mode), podľa vašich preferencií.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">📝 Typy otázok v teste</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-400">
                        <li>Otázky môžu byť výberového typu (jedna správna odpoveď z viacerých možností).</li>
                        <li>Otvorené otázky, kde musíte napísať číselnú odpoveď sami.</li>
                        <li>Čísla môžete zapisovať s desatinnou čiarkou <strong>(1,25)</strong> alebo bodkou <strong>(1.25)</strong>.</li>
                        <li>Odporúčame zaokrúhľovať odpovede na <strong>dve desatinné miesta</strong>, ak nie je uvedené inak.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">⏱️ Časový limit</h3>
                    <p class="text-gray-700 dark:text-gray-400">
                        Hneď po zobrazení otázky sa začne odpočítavať čas na jej zodpovedanie. Každá otázka sa zobrazuje samostatne.
                        Snažte sa odpovedať včas – rýchlosť je tiež hodnotená!
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">🔐 Prístup bez registrácie</h3>
                    <p class="text-gray-700 dark:text-gray-400">
                        Na vyplnenie testov sa <strong>nemusíte prihlasovať</strong>. Stačí začať – výsledky sa však ukladajú anonymne spolu s vašou polohou (mesto a štát).
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">📊 Výsledky a odporúčania</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-400">
                        <li>Na konci testu uvidíte, ktoré odpovede boli správne a ktoré nesprávne – aj s vysvetlením.</li>
                        <li>Zobrazíme vám odporúčanie, akú tému by ste si mali zopakovať.</li>
                        <li>Porovnáte si svoj čas riešenia s <strong>priemerným časom ostatných používateľov</strong>.</li>
                        <li>Svoje výsledky si môžete <strong>exportovať do PDF</strong> pre ďalšie použitie alebo vytlačenie.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-base text-gray-600 dark:text-gray-400">Ste pripravení? <span class="font-semibold">Začnite svoj matematický tréning teraz!</span></p>
            </div>
        </div>
    </div>
@endsection
