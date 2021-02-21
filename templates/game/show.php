<div class="flex bg-white md:h-60 h-24	 dark:bg-gray-800 rounded-lg shadow mb-5">
    <div class="flex-none w-24 md:w-60  relative">
        <img src="<?= $game->getImage(); ?>" class="absolute rounded-lg inset-0 w-full h-full object-cover"/>
    </div>
    <div class="flex-auto p-6">
        <div class="flex flex-wrap">
            <h1 class="flex-auto text-xl font-semibold dark:text-gray-50">
                <?= $game->getName(); ?>
            </h1>

            <table class="col-span-2 table p-4 bg-white shadow rounded-lg w-full ">
                <thead>
                <tr class="text-left">
                    <th class="border-b-2 p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                        User
                    </th>
                    <th class="border-b-2 p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                        Score
                    </th>
                    <th class="border-b-2 p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                    </th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($scores as $score): ?>
                    <tr class="text-gray-700">
                        <td class="border-b-2 p-4 dark:border-dark-5">
                            <?= $score->getPlayer()->getUsername(); ?>
                        </td>
                        <td class="border-b-2 p-4 dark:border-dark-5">
                            <?= $score->getScore(); ?>                    
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>