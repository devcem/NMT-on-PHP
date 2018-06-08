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

	function transform_array($filename){
		$output = array();

		$data  = file_get_contents($filename);
		$lines = explode("\n", $data);

		foreach ($lines as $key => $line) {
			$line     = explode("\t", $line);
			$output[] = array(tokenize($line[0]), tokenize(@$line[1]));
		}

		return $output;
	}

	function translate($text, $from, $to, $data){
		$text = tokenize($text);
		$possible_translations = array();
		$sentence_counts = array();

		foreach ($data as $key => $line_words) {
			foreach ($text as $token_index => $word) {
				if($line_words[$from] && in_array($word, $line_words[$from])){
					foreach ($line_words[$to] as $key => $line_word) {
						@$possible_translations[$word][$line_word]+=1 / ($possible_translations[$word][$line_word] + count($line_words[$to]));
					}

					foreach ($text as $token_index2 => $sub_word) {
						if(in_array($sub_word, $line_words[$from]) && $sub_word != $word){
							foreach ($line_words[$to] as $key => $line_word) {
								@$possible_translations[$word][$line_word]+=1;
							}
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
				print_r($sentence_counts[$token_key] / $score);
				print_r("\n");
				if($sentence_counts[$token_key] / $score < count($sentence_counts)){
					$output[] = $word;
				}
			}
		}

		return $output;
	}

	$data = transform_array('tur.txt');
	$translation0 = translate('i want to eat lunch', 0, 1, $data);

	print_r($translation0);