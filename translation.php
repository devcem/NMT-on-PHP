<?php

	set_time_limit(-1);
	ini_set('memory_limit', '-1');

	function tokenize($text){
		if($text){
			$text = strtolower($text);
			$text = str_replace('.', '', $text);
			$text = str_replace('!', '', $text);
			$text = str_replace('?', '', $text);

			$exploded = explode(" ", $text);
			$exploded = array_map(function($word){
				return trim($word);
			}, $exploded);

			return $exploded;
		}else{
			return '';
		}
	}

	function preprocess($text){
		$text = str_replace(array('\'ll', '&apos;', '&quot;', ','), array(' will', '', '', ''), $text);

		return $text;
	}

	function transform_array($filename){
		$output = array();

		$data  = file_get_contents($filename);

		//Preprocess text
		$data  = preprocess($data);

		$lines = explode("\n", $data);

		foreach ($lines as $key => $line) {
			$line     = explode("\t", $line);
			$output[] = array(tokenize($line[0]), tokenize(@$line[1]));
		}

		return $output;
	}

	function filter_data($data, $to, $limit){
		$output = array();
		$locked = true;
		$count  = 0;

		while($locked){
			if(count($data[$count][$to]) <= $limit + 5){
				$output[] = $data[$count];
			}else{
				$locked = false;
			}

			$count++;
		}

		return $output;
	}

	function corpus_array($file0, $file1){
		$output = array();

		$data0  = file_get_contents($file0);
		$data0  = preprocess($data0);

		$lines0 = explode("\n", $data0);

		$data1  = file_get_contents($file1);
		$data1  = preprocess($data1);

		$lines1 = explode("\n", $data1);

		foreach ($lines0 as $key => $line0) {
			$line1 = $lines1[$key];
			$output[] = array(tokenize($line0), tokenize($line1));
		}

		return $output;
	}

	function translate($text, $from, $to, $data){
		$text = tokenize($text);
		//$data = filter_data($data, $to, count($text));

		$possible_translations = array();
		$sentence_counts = array();

		$to_word_counts = array();

		foreach ($data as $key => $line_words) {
			foreach ($line_words[$to] as $index => $word) {
				@$to_word_counts[$word]++;
			}
		}

		foreach ($data as $key => $line_words) {
			foreach ($text as $token_index => $word) {
				if($line_words[$from] && in_array($word, $line_words[$from])){
					foreach ($line_words[$to] as $key => $line_word) {
						@$possible_translations[$word][$line_word]+=1 / ($possible_translations[$word][$line_word] + count($line_words[$to]));
					}

					$extra_score = 1;
					foreach ($text as $token_index2 => $sub_word) {
						if(in_array($sub_word, $line_words[$from]) && $sub_word != $word){
							foreach ($line_words[$to] as $key => $line_word) {
								@$possible_translations[$word][$line_word]+=$extra_score;
							}

							$extra_score+=1;
						}
					}

					arsort($possible_translations[$word]);
					$possible_translations[$word] = array_slice($possible_translations[$word], 0, 3);

					@$sentence_counts[$word]++;
				}
			}
		}

		print_r($sentence_counts);
		print_r($possible_translations);

		$output = array();

		foreach ($possible_translations as $token_key => $words) {
			foreach ($words as $word => $score) {
				@$output[$word]+=$score;
			}
		}

		return $output;
	}

	$data = transform_array('tur.txt');
	$translation0 = translate('i want to eat lunch', 0, 1, $data);

	print_r($translation0);