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

    <!-- internal CSS for Title -->
    <style>
        .title {
            font-family: "Arial Black", serif;
            font-size: 3em;
            color: darkblue;
            background-color: cornflowerblue;
            text-align: center;
            vertical-align: center;
            border-style: none
        }
    </style>
</head>
<body>

<?php require_once 'connection.php';?>

<!-- Page Header starts  -->
<div class="header">
    <table style="width:100%">
        <!-- Title  -->
        <tr class="title">
            <td colspan="9">
                <span>Superior Movies</span>
            </td>
        </tr>

        <!-- Menu Bar  -->
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
<!-- Page Header ends  -->


<div id="detail">

    <!-- Home page code  starts -->
    <div id="home_page" class="homepage">
          <table style="width:100%;height:100vh">
              <tr>
                    <td style="width:10%"></td>
                    <td style="width:80%">
                        <span style="text-align: center;vertical-align: center">
                            <h1 style="font-size:150px;color:black">

                                Welcome to Superior Movies
                            </h1>
                             <h3 style="font-size:60px;color:darkblue">
                               Authentic movie ratings that are made for you, by you.


                            </h3>
                        </span>
                    </td>
                    <td style="width:10%"></td>
              </tr>
         </table>
    </div>
    <!-- Home page code  ends -->

    <!-- Rate Movies page code  starts -->

    <div hidden id="rate_movies_page">
        <br>
        <form id="rate_movies_form" method="post" onsubmit="return saveData();" enctype="multipart/form-data">
            <table style="width:100%">
                <thead class="tableheader">
                    <tr>
                        <th class="grid" style="width:4%"></th>
                        <th class="grid" style="width:5%" ></th>
                        <th class="grid" style="width:5%" ></th>
                        <th class="grid" style="width:1%"></th>
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
    $query = "select id, imageurl, name from movie order by name";
    $conn = init_db_connection();
    $result =  mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $count = 0;
        while ($data = mysqli_fetch_assoc($result)) {
?>
                    <tr class="tablerow">
                        <td class="grid"></td>
                        <td class="grid">
                            <input hidden name="tableRow[<?php echo $count; ?>][id]" id="id" type="text" value="<?php echo $data['id']; ?>">
                        </td>
                        <td class="grid" style="text-align: center">
                            <img src="<?php echo $data['imageurl']; ?>" height="150px">
                        </td>
                        <td class="grid"></td>
                        <td class="grid" style="text-align: left">
                            <span><?php echo $data['name']; ?></span>
                        </td>
                        <td class="grid" style="text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="1">
                        </td>
                        <td class="grid" style="text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="2">
                        </td>
                        <td class="grid" style="text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="3">
                        </td>
                        <td class="grid" style="text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="4">
                        </td>
                        <td class="grid" style="text-align: center">
                            <input name="tableRow[<?php echo $count; ?>][rating]" type="radio" value="5">
                        </td>
                        <td class="grid"></td>
                    </tr>
<?php
             $count++;
        }
    }
    close_db_connection($conn);
?>
                    <tr class="tablerow" style="border-style: none">
                        <td colspan="11" style="height: 25px">
                        </td>
                    </tr>
                    <tr class="tablerow" style="border-style: none">
                        <td colspan="11" style="text-align: center">
                            <input class="button" type="submit" value="Save">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <!-- Rate Movies page code  ends -->

    <!-- View Rankings page code  starts -->
    <div hidden id="view_rankings_page">
        <br>
        <table style="width:100%">
            <thead class="tableheader">
            <tr>
                <th class="grid" style="width:14%"></th>
                <th class="grid" style="width:5%"></th>
                <th class="grid" style="width:1%"></th>
                <th class="grid" style="width:25%; text-align: left">Name</th>
                <th class="grid" style="width:10%">No. of Ratings</th>
                <th class="grid" style="width:10%">Average Rating</th>
                <th class="grid" style="width:20%"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query =
                "select M.name, M.imageurl, count(MR.rating) as rating_count, round(avg(MR.rating), 2) as avg_rating " .
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
                        <td class="grid" style="text-align: center">
                            <img src="<?php echo $data['imageurl']; ?>" height="150px">
                        </td>
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
    <!-- View Rankings page code  ends -->

    <!-- About page code  starts -->
    <div hidden id="about_page" class="aboutpage">
        <table style="width:100%; height:82vh">
            <tr>
                <td style="width:10%"></td>
                <td style="width:80%">
                <span style="text-align: center;vertical-align: center">
                       <h1 style="font-size:60px;color:black">
                        For this website our time and dedication was
                        placed mostly on the applications and functions that we wished to include in our current
                        prototype of our project. Our movie rating page was made for viewers to have an authentic
                        experience; get ratings that are not influenced by money or deals; rather, our websites
                        pride itself in authentic movie reviews that are decided by you!
                        </h1>
                        <h2 style="font-size:50px;color:black">
                        We are currently drawing up graphic designs for new features on our website that we hope to
                        integrate in future prototypes of our movie page. With these new additions come a see movies
                        page, where we display movies and where to watch based on genre… stay tuned!
                        </h2>
                        <h3 style="font-size:40px;color:#29575F;text-align: center">
                        About the Creators
                        </h3>
                        <h4 style="font-size:30px;color:#29575F;text-align: left">
                        Hi my name is Alisha Jain and I am the storyboard creator, where I created the design and
                        background for this website! For this website, I loved created the entire design and have fun
                        with it all!
                        </h4>
                        <h4 style="font-size:30px;color:#29575F;text-align: left">
                        Hello, my name is Aavan Vadiwala, and I am the data specialist for this project! Since I love
                        coding, I was able allow my love for coding really shine!
                        </h4>
                        <h4 style="font-size:30px;color:#29575F;text-align: left">
                        Hey my name is Areeba Asaduzzaman and I was the web master, and I loved seeing the entire
                         project come to life after weeks of hard work and putting it all together working with
                         Aavan and Alisha!
                        </h4>
                 </span>
                </td>
                <td style="width:10%"></td>
            </tr>
        </table>
    </div>
    <!-- About page code  ends -->
</div>
</body>
</html>