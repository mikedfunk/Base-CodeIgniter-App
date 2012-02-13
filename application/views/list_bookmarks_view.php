<html>
<head>
    <title></title>
</head>

<body>
    <section>
        <div class="container">
            <div class="page-header">
                <h1>My Bookymarks</h1>
            </div><!--page-header-->

            <p><a class="btn btn-success">Add Bookymark</a></p><?php
            // loop through bookmarks
            if ($bookmarks->num_rows() > 0):
                $result = $bookmarks->result();
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>URL</th>

                        <th>Description</th>
                    </tr>
                </thead><?php 
                    foreach ($result as $item):
                ?>

                <tr>
                    <td><?=$item->url?></td>

                    <td><?=$item->description?></td>
                </tr><?php 
                    endforeach;
                ?>
            </table>
			<?=$this->pagination->create_links()?>
            <?php
            else:
            ?>

            <div class="alert alert-error ">
                No bookymarks found. Add one!
            </div><?php
            endif; 
            ?>
        </div><!--container-->
    </section>
</body>
</html>
