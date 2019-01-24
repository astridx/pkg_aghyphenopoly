      var Hyphenopoly = {
            require: {
                "de-de": "Silbentrennungsalgorithmus",
                "en-gb": "Supercalifragilisticexpialidocious"
            },
            fallbacks: {
                    "de-de": "de"
                },            
            paths: {
                patterndir: "/media/plg_system_aghyphenopoly/hyphenopoly/patterns/",
                maindir: "/media/plg_system_aghyphenopoly/hyphenopoly/"
            },            
            setup: {
                selectors: {
                    ".site": {
                         minWordLength: 6,
                         leftmin: 4,
                         rightmin: 4
                    },
                    ".hyphenopoly": {
                         minWordLength: 6,
                         leftmin: 4,
                         rightmin: 4
                    },
                    "html": {
                         minWordLength: 6,
                         leftmin: 4,
                         rightmin: 4
                    }
                }
            }
        };
