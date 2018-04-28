<?php

    if(isset($_GET['p_id']))
    {
        $the_get_post_id = $_GET['p_id'];

        $query = "SELECT * FROM posts WHERE post_id = $the_get_post_id";
        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($result))
        {
            $post_id            = $row['post_id'];
            $post_category_id   = $row['post_category_id'];
            $post_title         = $row['post_title'];
            $post_author        = $row['post_author'];
            $post_date          = $row['post_date'];
            $post_image         = $row['post_image'];
            $post_content       = $row['post_content'];
            $post_tags          = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_status        = $row['post_status'];
        }
    }

    if (isset($_POST['update_post'])) 
    {
       $post_title          =  mysqli_real_escape_string($connection, trim($_POST['post_title']));
       $post_category_id    =  mysqli_real_escape_string($connection, trim($_POST['post_category_id']));
       $post_author         =  mysqli_real_escape_string($connection, trim($_POST['post_author']));
       $post_status         =  mysqli_real_escape_string($connection, trim($_POST['post_status']));

       $post_image          =  $_FILES['image']['name'];
       $post_image_tmp      =  $_FILES['image']['tmp_name'];

       $post_tags           =  mysqli_real_escape_string($connection, trim($_POST['post_tags']));
       $post_content        =  mysqli_real_escape_string($connection, trim($_POST['post_content']));

       move_uploaded_file($post_image_tmp, "../images/$post_image");

       if(empty($post_image))
       {
            $query = "SELECT * FROM posts WHERE post_id = $the_get_post_id";
            $select_image = mysqli_query($connection, $query);

            while($row = mysqli_fetch_array($select_image))
            {
                $post_image = $row['post_image'];
            }
       }


       $query = "UPDATE posts SET post_category_id = $post_category_id, post_title = '$post_title', 
                post_author = '$post_author', post_date = now(), post_image = '$post_image', 
                post_content = '$post_content', post_tags = '$post_tags', 
                post_comment_count = $post_comment_count, post_status = '$post_status' 
                WHERE post_id = $the_get_post_id";

        $result = mysqli_query($connection, $query);

        confirmQuery($result);


    }

?>

<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" class="form-control" value="<?php echo $post_title; ?>">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select name="post_category_id" class="form-control">
            <?php
            
                $query = "SELECT * FROM categories";
                $result = mysqli_query($connection, $query);

                confirmQuery($result);

                while($row = mysqli_fetch_array($result))
                {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
            
            ?>
            
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" name="post_author" class="form-control" value="<?php echo $post_author; ?>">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" name="post_status" class="form-control" value="<?php echo $post_status; ?>">
    </div>

    <div class="form-group">
        <img class='img-responsive' width = "200" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" name="post_tags" class="form-control" value="<?php echo $post_tags; ?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" value="Edit Post" name="update_post" class="btn btn-primary">
    </div>

</form>