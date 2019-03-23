/** translation of Taylor Otwell's str_slug helper from Laravel **/
/** https://gist.github.com/Lucassifoni/0e94e03a63b53518ddf466f22aa1cf19 **/

/**
 * Trims a string for a given start/end character
 * @param {string} string
 * @param {string} pattern
 */
const trimChar = function trimChar(string, pattern) {
    if (typeof pattern.toString === 'undefined') {
        throw new Error('pattern must be a string or castable to string');
    }
    if (typeof string.toString === 'undefined') {
        throw new Error('string must be a string or castable to string');
    }
    let str = string.toString();
    let needle = pattern.toString();
    while (str.charAt(0) === needle) {
        str = str.substring(1);
    }
    while (str.charAt(str.length - 1) === needle) {
        str = str.substring(0, str.length - 1);
    }
    return str;
};

/**
 * Replaces all occurences of all given patterns with a single replacement
 * @param {string} string
 * @param {array} patternArray
 * @param {string} replacement
 * @returns {string} str
 */
const arrayReplaceSingle = function arrayReplaceSingle(string, patternArray, replacement) {
    if (typeof string.toString === 'undefined') {
        throw new Error('string parameter must be a string or cast-able to string.');
    }
    const l = patternArray.length;
    if (l === 0) {
        throw new Error('Patterns array must have members.');
    }
    let str = string.toString();
    for (let i = 0; i < l; i += 1) {
        if (typeof patternArray[i].toString === 'undefined') {
            throw new Error('Every pattern array member must be a string or cast-able to string');
        }
        str = str.replace(new RegExp(patternArray[i], 'g'), replacement);
    }
    return str;
};

/**
 * CharMap allowing language-aware replacements
 * @type {object}
 */
const charMap = {
    '0': ['°', '₀', '۰', '０'],
    '1': ['¹', '₁', '۱', '１'],
    '2': ['²', '₂', '۲', '２'],
    '3': ['³', '₃', '۳', '３'],
    '4': ['⁴', '₄', '۴', '٤', '４'],
    '5': ['⁵', '₅', '۵', '٥', '５'],
    '6': ['⁶', '₆', '۶', '٦', '６'],
    '7': ['⁷', '₇', '۷', '７'],
    '8': ['⁸', '₈', '۸', '８'],
    '9': ['⁹', '₉', '۹', '９'],
    'a': ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا', 'ａ', 'ä'],
    'b': ['б', 'β', 'ب', 'ဗ', 'ბ', 'ｂ'],
    'c': ['ç', 'ć', 'č', 'ĉ', 'ċ', 'ｃ'],
    'd': ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ', 'ｄ'],
    'e': ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ', 'ｅ'],
    'f': ['ф', 'φ', 'ف', 'ƒ', 'ფ', 'ｆ'],
    'g': ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ', 'ｇ'],
    'h': ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ', 'ｈ'],
    'i': ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ', 'ی', 'ｉ'],
    'j': ['ĵ', 'ј', 'Ј', 'ჯ', 'ج', 'ｊ'],
    'k': ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک', 'ｋ'],
    'l': ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ', 'ｌ'],
    'm': ['м', 'μ', 'م', 'မ', 'მ', 'ｍ'],
    'n': ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ', 'ｎ'],
    'o': ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ', 'ｏ', 'ö'],
    'p': ['п', 'π', 'ပ', 'პ', 'پ', 'ｐ'],
    'q': ['ყ', 'ｑ'],
    'r': ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ', 'ｒ'],
    's': ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს', 'ｓ'],
    't': ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ', 'ｔ'],
    'u': ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ', 'ｕ', 'ў', 'ü'],
    'v': ['в', 'ვ', 'ϐ', 'ｖ'],
    'w': ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ', 'ｗ'],
    'x': ['χ', 'ξ', 'ｘ'],
    'y': ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ', 'ｙ'],
    'z': ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ', 'ｚ'],
    'aa': ['ع', 'आ', 'آ'],
    'ae': ['æ', 'ǽ'],
    'ai': ['ऐ'],
    'ch': ['ч', 'ჩ', 'ჭ', 'چ'],
    'dj': ['ђ', 'đ'],
    'dz': ['џ', 'ძ'],
    'ei': ['ऍ'],
    'gh': ['غ', 'ღ'],
    'ii': ['ई'],
    'ij': ['ĳ'],
    'kh': ['х', 'خ', 'ხ'],
    'lj': ['љ'],
    'nj': ['њ'],
    'oe': ['ö', 'œ', 'ؤ'],
    'oi': ['ऑ'],
    'oii': ['ऒ'],
    'ps': ['ψ'],
    'sh': ['ш', 'შ', 'ش'],
    'shch': ['щ'],
    'ss': ['ß'],
    'sx': ['ŝ'],
    'th': ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
    'ts': ['ц', 'ც', 'წ'],
    'ue': ['ü'],
    'uu': ['ऊ'],
    'ya': ['я'],
    'yu': ['ю'],
    'zh': ['ж', 'ჟ', 'ژ'],
    '(c)': ['©'],
    'A': ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ', 'Ａ', 'Ä'],
    'B': ['Б', 'Β', 'ब', 'Ｂ'],
    'C': ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ', 'Ｃ'],
    'D': ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ', 'Ｄ'],
    'E': ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə', 'Ｅ'],
    'F': ['Ф', 'Φ', 'Ｆ'],
    'G': ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ', 'Ｇ'],
    'H': ['Η', 'Ή', 'Ħ', 'Ｈ'],
    'I': ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ', 'Ｉ'],
    'J': ['Ｊ'],
    'K': ['К', 'Κ', 'Ｋ'],
    'L': ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल', 'Ｌ'],
    'M': ['М', 'Μ', 'Ｍ'],
    'N': ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν', 'Ｎ'],
    'O': ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ', 'Ｏ', 'Ö'],
    'P': ['П', 'Π', 'Ｐ'],
    'Q': ['Ｑ'],
    'R': ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ', 'Ｒ'],
    'S': ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ', 'Ｓ'],
    'T': ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ', 'Ｔ'],
    'U': ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ', 'Ｕ', 'Ў', 'Ü'],
    'V': ['В', 'Ｖ'],
    'W': ['Ω', 'Ώ', 'Ŵ', 'Ｗ'],
    'X': ['Χ', 'Ξ', 'Ｘ'],
    'Y': ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ', 'Ｙ'],
    'Z': ['Ź', 'Ž', 'Ż', 'З', 'Ζ', 'Ｚ'],
    'AE': ['Æ', 'Ǽ'],
    'Ch': ['Ч'],
    'Dj': ['Ђ'],
    'Dz': ['Џ'],
    'Gx': ['Ĝ'],
    'Hx': ['Ĥ'],
    'Ij': ['Ĳ'],
    'Jx': ['Ĵ'],
    'Kh': ['Х'],
    'Lj': ['Љ'],
    'Nj': ['Њ'],
    'Oe': ['Œ'],
    'Ps': ['Ψ'],
    'Sh': ['Ш'],
    'Shch': ['Щ'],
    'Ss': ['ẞ'],
    'Th': ['Þ'],
    'Ts': ['Ц'],
    'Ya': ['Я'],
    'Yu': ['Ю'],
    'Zh': ['Ж'],
    ' ': ["\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80", "\xEF\xBE\xA0"],
};

/**
 * Bulgar & German specific charmaps
 * @type {{bg: *[], de: *[]}}
 */
const languageSpecific = {
    'bg': [
        ['х', 'Х', 'щ', 'Щ', 'ъ', 'Ъ', 'ь', 'Ь'],
        ['h', 'H', 'sht', 'SHT', 'a', 'А', 'y', 'Y'],
    ],
    'de': [
        ['ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü'],
        ['ae', 'oe', 'ue', 'AE', 'OE', 'UE'],
    ],
};

/**
 * Returns a language-specific charmap for German and Bulgare
 * @param {string} language
 * @returns {Array | null}
 */
const languageSpecificCharsArray = function languageSpecificCharsArray(language) {
    if (typeof language.toString === 'undefined') {
        throw new Error('language parameter must be a string or castable to string');
    }
    const l = languageSpecific[language.toString()];
    if (typeof l !== 'undefined') {
        return l;
    }
    return null;
};

/**
 * Ascii-fies a given string with a language-specific phonetic replacement
 * @param {string} string
 * @param {string} language
 * @returns {string | * | void}
 */
const ascii = function ascii(string, language = 'en') {
    if (typeof language.toString === 'undefined') {
        throw new Error('language parameter must be a string or castable to string');
    }
    const languageSpecific = languageSpecificCharsArray(language.toString());
    let str = string;
    if (languageSpecific !== null) {
        str = string.replace(languageSpecific[0], languageSpecific[1]);
    }
    const charKeys = Object.keys(charMap);
    charKeys.forEach((key) => {
        str = arrayReplaceSingle(str, charMap[key], key);
    });
    return str.replace(/[^\x20-\x7E]/g, '');
};

/**
 * Slugifies a string according to the str_slug laravel helper
 * @param {string} string
 * @param {string} separator
 * @param {string} language
 * @returns {string | *}
 */
const str_slug = function str_slug(string, separator = '-', language = 'en') {
    let str = ascii(string);
    if (typeof str.toString === 'undefined') {
        throw new Error('An error has occured while converting the input string to ascii.');
    }
    str = str.toString();
    const flip = separator === '-' ? '_' : '-';
    str = str.replace(new RegExp(flip, 'g'), separator);
    str = str.replace(new RegExp('@', 'g'), `${separator}at${separator}`);
    str = str.replace('/![^' + separator + '\w\d\s/g', '');
    str = str.toLowerCase();
    str = str.replace(/[\s]/g, separator);
    // str = trimChar(str, '-');
    return str;
};

export default str_slug;
