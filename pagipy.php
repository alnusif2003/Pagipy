<?php
function pagination($query, $con, $alias = 'page',  $basePage = '', $rows = 15)
{
    if (isset($_GET[$alias])) {
        $currentPage = $_GET[$alias];
    } else {
        $currentPage = 1;
    }

    $result = mysqli_query($con, $query);
    $lines = mysqli_num_rows($result);
    $pages = ceil($lines / $rows);

    if ($pages == 1) {
        return "";
    }

    if ($currentPage == $pages) {
        if (($currentPage - 3) > 0) {
            $subtract = 3;
        } else if (($currentPage - 2) > 0) {
            $subtract = 2;
        } else if (($currentPage - 1) > 0) {

            $subtract = 1;
        } else {
            $subtract = 0;
        }
        $pagination = "
        <nav aria-label=\"pagination\">
        <ul class=\"pagination pagination-sm\">";
        for ($page = $currentPage - $subtract; $page < $pages; $page++) {
            $pagination .= "<li class=\"page-item\"><a class=\"page-link bg-dark text-white\" href=\"$basePage?page=$page\">$page</a></li>";
        }

        $pagination .= "
                <li class=\"page-item disabled\">
                    <a class=\"page-link bg-light\" href=\"#\" tabindex=\"-1\">$currentPage</a>
                </li>
            </ul>
        </nav>";
    } else if ($currentPage == 1) {
        $pagination = "
    <nav aria-label=\"pagination\">
    <ul class=\"pagination pagination-sm\">
        <li class=\"page-item disabled\">
            <a class=\"page-link bg-light\" href=\"#\" tabindex=\"-1\">$currentPage</a>
        </li>";
        if ($pages >= 3) {
            $max = 3;
        } else {
            $max = $pages;
        }
        for ($page = $currentPage + 1; $page <= $max; $page++) {
            $page = strval($page);
            $pagination .= "<li class=\"page-item\"><a class=\"page-link bg-dark text-white\" href=\"$basePage?page=$page\">$page</a></li>";
        }

        $pagination .= "
        </ul>
    </nav>";
    } else {
        $before = $currentPage - 1;
        $after = $currentPage + 1;
        $pagination = "
    <nav aria-label=\"pagination\">
    <ul class=\"pagination pagination-sm\">
        <li class=\"page-item\"><a class=\"page-link bg-dark text-white\" href=\"$basePage?page=$before\">$before</a></li>
        <li class=\"page-item disabled\">
            <a class=\"page-link bg-light\" href=\"#\" tabindex=\"-1\">$currentPage</a>
        </li>";
        $pagination .= "<li class=\"page-item\"><a class=\"page-link bg-dark text-white\" href=\"$basePage?page=$after\">$after</a></li>
        </ul>
        </nav>";
    }
    return $pagination;
}
