# NMT-on-PHP
Statistical machine translation on PHP

Machine learning algorithms can use RNN and LTSM methods to predict possible translations. This project aims to get translation without creating model. I would like to do this thing to understand RNN and LTSM methods and their necessity.

It basically scans the database and calculates to probability and repetition count. With some calculations we get basic translation predictions.

I choose English-Turkish language model because of my native language. Also Turkish language is very different than English on grammar base.

Also I choose PHP because, i simply good at it. After building model, i could change it to better language to get better performance and results.

Statistical formula to find translation of a word :
```$score = 1 / ( word_count + 0.1 )```

For sequence words, we add more score to original word :
```$score+= 1 / ( word_count + 0.1 )```

## Examples
English input :
```i want to eat lunch```

Correct translation :
```Öğle yemeği yemek istiyorum```

Turkish output from algorithm :
```Bir Öğle yemek istiyorum```

Scores of translation :
```
Array
(
    [yemek] => 66.31402692896
    [miyim] => 16.165636396182
    [istiyorum] => 34.932213598677
    [yiyebilir] => 21.714204000751
    [bir] => 29.152451494235
    [gitmek] => 17.003753023206
    [zorunda] => 15.341370578592
    [onu] => 14.610108862348
    [yemeği] => 13.840352357107
    [kaldım] => 13.025281365118
    [Öğle] => 32.79399782063
    [zorundayım] => 10.766623059305
    [kıkır] => 10.294173745878
    [hazır] => 10.197058634123
    [bize] => 10.197058634123
)
```

As you can see it still needs more improvement, but simple statistical calculations you could get a translation, even without a vocabulary set. Just feed the algorithm with lots of sentence and it will predict better results.

I will work in this project and will try to implement GRU and sequence based system in future. With this way, it will be better and can be applied to other languages.

I also have to say that i started to work with English-Dutch pair because of the similarity of these two languages but i decided to work with Turkish to understand the algorithm behind the sequence translations.

So you could simply fork and make it work on Dutch.

Also you could download more dataset from this address :
http://www.manythings.org/anki/