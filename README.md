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

## Update (v1.1)

I've changed some calculations to get better results. For example i added another score function to determine word repeat counts. It helps to understand if word is rare or not.

With some improvements, it gets better results and i will continue to work on it. Here is the new results :

English input :
```i want to eat lunch```

Correct translation :
```Öğle yemeği yemek istiyorum```

Turkish output from algorithm :
```Öğle yemeği yemek istiyorum```

Scores of translation :
```
Array
(
    [i] => Array
        (
            [istiyorum] => 369.67920026876
            [yemek] => 80.770182839243
            [miyim] => 33.369151618532
        )

    [eat] => Array
        (
            [yemek] => 104.31712927019
            [istiyorum] => 19.593281973175
            [zorundayım] => 12.820448362323
        )

    [to] => Array
        (
            [istiyorum] => 261.86594467662
            [yemek] => 96.651928350944
            [gitmek] => 46.852823953631
        )

    [want] => Array
        (
            [istiyorum] => 417.0786226173
            [yemek] => 40.914343194859
            [onu] => 39.681962494134
        )

    [lunch] => Array
        (
            [yemeği] => 19.30880913996
            [Öğle] => 11.830944966924
            [yemedim] => 3.3333333333333
        )

)
```

It gets better with larger datasets. And i need to solve the relation between words to apply seq2seq feature fully. I'll try to design and optimized loop to get word sequence.

I'm also start to test it with French as well, here is the results :

French input :
```je ne sais pas quand je vais me réveiller```

Correct translation :
```i don't know when i'm going to wake up```

English output from algorithm :
```i don't know when i'm going to wake up```
