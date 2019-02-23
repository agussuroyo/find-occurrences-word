<?php

class Findoc
{

    public function explodeString($string = '')
    {
	return array_map('trim', explode(PHP_EOL, $string));
    }

    public function findOnItems($keyword = '', $items = [])
    {
	$displays = [];
	$lower = strtolower($keyword);

	if (empty($lower)) {
	    return $displays;
	}

	foreach ($items as $item) {

	    $formated = trim(strtolower($item));

	    if (empty($formated)) {
		continue;
	    }

	    if (strpos($formated, $lower) !== false) {
		$displays[] = $item;
	    }
	}
	
	return $displays;
    }

    public function buildResults($keys = [], $list = [])
    {
	$build = [];

	foreach ($keys as $key) {

	    $find = $this->findOnItems($key, $list);
	    if (empty($find)) {
		continue;
	    }

	    $result = implode(' - ', $find);

	    $build[] = "{$key}: {$result}";
	}

	return implode(PHP_EOL, $build);
    }

}

$strings = '';
$keywords = '';
$results = '';
if (isset($_POST['submit'])) {
    $findoc = new Findoc();

    $strings = filter_input(INPUT_POST, 'strings');
    $keywords = filter_input(INPUT_POST, 'keywords');

    $list = $findoc->explodeString($strings);
    $keys = $findoc->explodeString($keywords);

    $results = $findoc->buildResults($keys, $list);
}
?>

<!doctype html>
<html>
    <head>
        <title></title>
    </head>
    <body>
	<div>
	    <form action="" method="post">
		<div>
		    <label>Strings</label>
		    <br/>
		    <textarea name="strings" rows="10" cols="50"><?php echo $strings; ?></textarea>
		</div>
		<div>
		    <label>Keywords</label>
		    <br/>
		    <textarea name="keywords" rows="5" cols="50"><?php echo $keywords; ?></textarea>
		</div>
		<div>
		    <label>Output</label>
		    <br/>
		    <textarea name="results" rows="10" cols="50" readonly=""><?php echo $results; ?></textarea>
		</div>
		<div>
		    <br/>
		    <button type="submit" name="submit" value="1">Search</button>
		</div>
	    </form>
	</div>
    </body>
</html>
