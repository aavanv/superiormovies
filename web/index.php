<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Superior Movies</title>
    <link rel="stylesheet" href="superiormovies.css?timestamp=<?php echo filemtime('superiormovies.css'); ?>">
    <script src="superiormovies.js?timestamp=<?php echo filemtime('superiormovies.js'); ?>"></script>
    <script>
        let currentSelection = "home";
    </script>
</head>
<body>

<?php require_once 'connection.php';?>

<div class="header">
    <table style="width:100%">
        <tr class="title">
            <td colspan="9">
                <span>Superior Movies</span>
            </td>
        </tr>
        <tr style="background-color: lightskyblue; height:4em">
            <td style="width:35%"></td>
            <td>
                <span class="menuselected" id="home" onclick="displayHome(this)">Home</span>
            </td>
            <td style="width:5%"></td>
            <td>
                <span class="menu" id="rate_movies" onclick="rateMovies(this)">Rate Movies</span>
            </td>
            <td style="width:5%"></td>
            <td>
                <span class="menu" id="view_rankings" onclick="viewRankings(this)">View Movie Rankings</span>
            </td>
            <td style="width:5%"></td>
            <td>
                <span class="menu" id="about" onclick="about(this)">About</span>
            </td>
            <td style="width:35%"></td>
        </tr>
    </table>
</div>
<div id="detail">
    <div id="home_page" class="homepage">
        <table style="width:100%; height:82vh">
            <tr>
                <td style="width:50%"></td>
                <td style="width:30%">
                    <p>
                        Home page content comes here
                    </p>
                </td>
                <td style="width:20%"></td>
            </tr>
        </table>
    </div>
    <div hidden id="rate_movies_page">
        <br>
        <form id="rate_movies_form" method="post" onsubmit="return saveData();" enctype="multipart/form-data">
<!--        <form id="rate_movies_form" method="post" action="insert.php" enctype="multipart/form-data">-->
            <table style="width:100%">
                <thead class="tableheader">
                    <tr>
                        <th class="grid" style="width:10%"></th>
                        <th class="grid" style="width:5%" ></th>
                        <th class="grid" style="width:25%; text-align: left">Name</th>
                        <th class="grid" style="width:10%">1 Star</th>
                        <th class="grid" style="width:10%">2 Star</th>
                        <th class="grid" style="width:10%">3 Star</th>
                        <th class="grid" style="width:10%">4 Star</th>
                        <th class="grid" style="width:10%">5 Star</th>
                        <th class="grid" style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
<?php
    $query = "select id, name from movie order by name";
    $conn = init_db_connection();
    $result =  mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $count = 0;
        while ($data = mysqli_fetch_assoc($result)) {
?>
                    <tr class="tablerow">
                        <td class="grid" style="width:10%"></td>
                        <td class="grid" style="width:5%">
                            <input hidden name="tableRow[<?php echo $count; ?>][id]" id="id" type="text" value="<?php echo $data['id']; ?>">
                        </td>
                        <td class="grid" style="width:25%; text-align: left">
                            <span><?php echo $data['name']; ?></span>
                        </td>
                        <td class="grid" style="width:10%; text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="1">
                        </td>
                        <td class="grid" style="width:10%; text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="2">
                        </td>
                        <td class="grid" style="width:10%; text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="3">
                        </td>
                        <td class="grid" style="width:10%; text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="4">
                        </td>
                        <td class="grid" style="width:10%; text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="5">
                        </td>
                        <td class="grid" style="width:10%"></td>
                    </tr>
<?php
             $count++;
        }
    }
    close_db_connection($conn);
?>
                    <tr class="tablerow" style="border-style: none">
                        <td colspan="9" style="text-align: center">
                            <input class="button" type="submit" value="Save">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div hidden id="view_rankings_page">
        <br>
        <table style="width:100%">
            <thead class="tableheader">
            <tr>
                <th class="grid" style="width:20%"></th>
                <th class="grid" style="width:25%; text-align: left">Name</th>
                <th class="grid" style="width:10%">No. of Ratings</th>
                <th class="grid" style="width:10%">Average Rating</th>
                <th class="grid" style="width:20%"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query =
                "select M.name, count(MR.rating) as rating_count, round(avg(MR.rating), 2) as avg_rating " .
                "from movie_rating MR " .
                "join movie M ON MR.movie_id = M.id ".
                "group by MR.movie_id " .
                "order by avg_rating desc";
            $conn = init_db_connection();
            $result =  mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr class="tablerow">
                        <td class="grid"></td>
                        <td class="grid" style="text-align: left">
                            <span><?php echo $data['name']; ?></span>
                        </td>
                        <td class="grid" style="text-align: center">
                            <span><?php echo $data['rating_count']; ?></span>
                        </td>
                        <td class="grid" style="text-align: center">
                            <span><?php echo $data['avg_rating']; ?></span>
                        </td>
                        <td class="grid"></td>
                    </tr>
                    <?php
                }
            }
            close_db_connection($conn);
            ?>
            </tbody>
        </table>

    </div>
    <div hidden id="about_page" class="aboutpage">
        <table style="width:100%; height:82vh">
            <tr>
                <td style="width:50%"></td>
                <td style="width:30%">
                    <p>
                        About page content comes here
                    </p>
                </td>
                <td style="width:20%"></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>