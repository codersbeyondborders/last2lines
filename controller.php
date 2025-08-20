<?php
// require_once(__DIR__ . "/includes/session.php");
// require_once(__DIR__ . "/includes/connection.php");
// require_once(__DIR__ . "/includes/functions.php");
// require_once(__DIR__ . "/includes/analyticstracking.php");

/**
 * Encapsulates all data needed for the index page.
 *
 * This class moves all data fetching logic out of the global scope,
 * making the code more organized and easier to test.
 */
class PageData
{
    public int $totalAuthors = 0;
    public int $totalCouplets = 0;
    public array $activeChapter = [];
    public array $firstTwoCouplets = [];

    public function __construct()
    {
        // Ideally, get_number_of_authors() and getFirst2Couplets()
        // would be methods of a new database service class,
        // which would be passed into this class via dependency injection.
        // For this refactor, we'll assume they are still available as global functions.

        $this->totalAuthors = get_number_of_authors();
        $this->totalCouplets = $this->totalAuthors * 2;

        $this->activeChapter = $this->getActiveChapter();
        if (!empty($this->activeChapter)) {
            $this->firstTwoCouplets = getFirst2Couplets($this->activeChapter['chapter_id']);
        }
    }

    private function getActiveChapter(): array
    {
        $activeChapters = get_active_chapter();
        if ($activeChapters !== false) {
            foreach ($activeChapters as $ac) {
                return $ac;
            }
        }
        return [];
    }
}

// Instantiate the class to prepare data
$pageData = new PageData();

// Now, include the view to render the page
require_once(__DIR__ . "/index_view.php");
?>