<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Directory Contents</title>
  <link rel="stylesheet" href=".style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

  <div id="container">
  
    <h1>Colorado Property Records         <a href="index.html"><span>return to search</span></a></h1>
    
    <table class="sortable">
      <thead>
        <tr>
          <th>Filename</th>
          <th>Date Modified</th>
        </tr>
      </thead>
      <tbody>
      <?php
        // Opens directory
        $myDirectory=opendir(__DIR__."/Colorado");
        
        // Gets each entry
        while($entryName=readdir($myDirectory)) {
          $dirArray[]=$entryName;
        }
        
        // Finds extensions of files
        function findexts ($filename) {
          $filename=strtolower($filename);
          $exts = explode('.', $fileName);
          //$exts=split("[/\\.]", $filename);
          $n=count($exts)-1;
          $exts=$exts[$n];
          return $exts;
        }
        
        // Closes directory
        closedir($myDirectory);
        
        // Counts elements in array
        $indexCount=count($dirArray);
        
        // Sorts files
        sort($dirArray);
        
        // Loops through the array of files
        for($index=0; $index < $indexCount; $index++) {
        
          // Allows ./?hidden to show hidden files
          if($_SERVER['QUERY_STRING']=="hidden")
          {$hide="";
          $ahref="./";
          $atext="Hide";}
          else
          {$hide=".";
          $ahref="./?hidden";
          $atext="Show";}
          if(substr("$dirArray[$index]", 0, 1) != $hide) {
          
          //File Names Are
          $name=$dirArray[$index];
          $namehref=$dirArray[$index];
          
          // Gets Extensions 
          $extn=findexts($dirArray[$index]); 
          
          // Gets file size 
          $size=number_format(filesize($dirArray[$index]));
          
          //gets Date Modified Data. dunt work for shit
          $modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
          $timekey=date("YmdHis", filemtime($dirArray[$index]));

          if(is_dir($dirArray[$index])) {
            $extn="&lt;Directory&gt;"; 
            $size="&lt;Directory&gt;"; 
            $class="dir";
          } else {
            $class="file";
          }
          
          // Cleans up . and .. directories 
          if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;";}
          if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}

          //variable localization
          $input = $namehref;
          $output = explode('_', $input);
          //output 0 = city
          //output 1 = number
          //output 2 = street
          //output 3 = street & suffix ++ must be cleaned
          $jumper = explode('.', $output[3]);
          $output[3] = $jumper[0];

          $name = explode('.', $namehref);
          
          // Print 'em
          print
          ("

          <div class='container mt-1'>
        <div class='row d-flex justify-content-center'>
            <div class='card' style='width: 60rem;'>

                <!--<embed src='Colorado/2200_BALSAM_DR-pr.pdf' type='application/pdf' width='100%' height='600px' />
                    Use this for the popup so they're easily viewable.
                    LOL fuck u i did it with variables first
                -->

                <div class='card-body'>
                <embed class='card-img-top float-right' src='img/$name[0].png' type='image/jpg' alt='card cap' style='width: 15rem;'/>
                <h5 class='card-title'>$output[1] $output[2] $output[3]</h5>
                <p class='card-text'>$output[0] <br> last edited: img/$name[0].jpg</p>
                <a href='#' class='btn btn-primary'>Save</a>  <a href='#' class='btn btn-primary'>Sign</a>
                <details>
    <summary>Details</summary>
    Something small enough to escape casual notice.
    <embed src='Colorado/$namehref' width='800px' height='2100px' />
</details>
                </div>
            </div>
           
            </div>
        </div>
    </div>

          <tr class='$class'>
            <td><a href='./$namehref'>$name</a></td>
            <td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
          </tr>
          
          ");
          }
        }
      ?>
      </tbody>
    </table>
  
  </div>
  
</body>

</html>