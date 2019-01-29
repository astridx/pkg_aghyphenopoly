# pkg_hyphenopoly / Joomla Custom Plugin for hyphenation
 
# Quickstart

1. Install this package via Joomla! installer. 
Please activate the plugin via `Extension | Plugins` before you use it. 
If you do not find the plugin entry, you can search it via the search field.

b1

2. Path: By default Aghyphenopoly looks in the path 
`/media/plg_system_aghyphenopoly/hyphenopoly/patterns/` for .hpb-files (patterns) and 
in `/media/plg_system_aghyphenopoly/hyphenopoly/` for all other resources. 
You do not need to configure this value, if you like the default path and if you have 
installed Joomla in the root of your webserver. If you have installed Joomla in 
a subdirectory like `http://localhost/joomla-cms/` you need tho reconfigure the pathes. 
In this example you need to use '/joomla-cms/media/plg_system_aghyphenopoly/hyphenopoly/patterns/' 
for .hpb-files and `/joomla-cms/media/plg_system_aghyphenopoly/hyphenopoly/` for other resources. 
For more informations please see https://github.com/mnater/Hyphenopoly/wiki/Global-Hyphenopoly-Object#paths .

b2

3. Setup: The settings on the top apply to Aghyphenopoly in general. For more informations please see https://github.com/mnater/Hyphenopoly/wiki/Setup . 
Many settings can be set for each set of elements that are matched by the given selector. For more informations please see https://github.com/mnater/Hyphenopoly/wiki/Setup#selector-based-settings .

b3

4. Language: The language (require) field must be an object of key-value-pairs, 
where the keys are language codes and the values are a long word (>=12 characters) 
in the required language. `Hyphenopoly_Loader.js` feature tests the browser for 
CSS-hyphenation support of the required languages using the long word. 
If the feature test indicates that the browser doesn't support CSS-hyphenation for 
at least one language, all necessary ressources will be loaded and `Hyphenopoly.js` gets executed. 
Use this to test support for every language used on the current page. If e.g. the language 
of the page is `lang='de-DE'` you must require language `de-de` (case doesn't matter). 
For languages that aren't in the patterns directory a fallback must be defined (see below). 
To force the usage of `Hyphenopoly.js` (e.g. for testing or if you prefer to use your own patterns) 
the special keyword `FORCEHYPHENOPOLY` can be used as value. 
Note: Disable CSS-hyphenation while using `FORCEHYPHENOPOLY`. 
For more informations please see https://github.com/mnater/Hyphenopoly/wiki/Global-Hyphenopoly-Object#require and https://github.com/mnater/Hyphenopoly/wiki/Global-Hyphenopoly-Object#fallbacks .

b4

5. Exceptions: This tab provides exceptions for hyphenation. 
The exceptions object must contain language-codes as keys (or `global` for all languages, but global is not supportet with this plugin up to know). 
The values must be words separated by `,⎵` (comma, space), where a hyphen-minus marks 
the hyphenation points. If the word does not contain a hyphen, 
it will not be hyphenated by `Hyphenopoly.js`. For more informations please see https://github.com/mnater/Hyphenopoly/wiki/Setup#exceptions .

b5

# FAQ
## What is hyphenation algorithm?
A hyphenation algorithm is a set of rules, especially one codified for implementation in a computer program, that decides at which points a word can be broken over two lines with a hyphen.

# Support and New Features

This Joomla! Extension is a simple feature. But it is most likely, that your requirements are 
already covered or require very little adaptation.

If you have more complex requirements, need new features or just need some support, 
I am open to doing paid custom work and support around this Joomla! Extension. 

Contact me and we'll sort this out!
