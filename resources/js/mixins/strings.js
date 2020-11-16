import numeral from 'numeral';

export default {
    methods: {
        suffixedNumber(num) {
            if (num < 999) {
                return num;
            } else {
                return numeral(num).format('0.[0]a');
            }
        },

        /**
         * Return a URL-friendly slug.
         *
         * @param str
         * @returns {string}
         * @link https://gist.github.com/mathewbyrne/1280286#gistcomment-2588056
         */
        slugify(str) {
            let text = str.toString().toLowerCase().trim();

            const sets = {}
            sets.default = [
                { to: 'a', from: '[ÀÁÂÃÄÅÆĀĂĄẠẢẤẦẨẪẬẮẰẲẴẶ]' },
                { to: 'c', from: '[ÇĆĈČ]' },
                { to: 'd', from: '[ÐĎĐÞ]' },
                { to: 'e', from: '[ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ]' },
                { to: 'g', from: '[ĜĞĢǴ]' },
                { to: 'h', from: '[ĤḦ]' },
                { to: 'i', from: '[ÌÍÎÏĨĪĮİỈỊ]' },
                { to: 'j', from: '[Ĵ]' },
                { to: 'ij', from: '[Ĳ]' },
                { to: 'l', from: '[ĹĻĽŁ]' },
                { to: 'm', from: '[Ḿ]' },
                { to: 'n', from: '[ÑŃŅŇ]' },
                { to: 'o', from: '[ÒÓÔÕÖØŌŎŐỌỎỐỒỔỖỘỚỜỞỠỢǪǬƠ]' },
                { to: 'oe', from: '[Œ]' },
                { to: 'p', from: '[ṕ]' },
                { to: 'r', from: '[ŔŖŘ]' },
                { to: 's', from: '[ßŚŜŞŠ]' },
                { to: 't', from: '[ŢŤ]' },
                { to: 'u', from: '[ÙÚÛÜŨŪŬŮŰŲỤỦỨỪỬỮỰƯ]' },
                { to: 'w', from: '[ẂŴẀẄ]' },
                { to: 'x', from: '[ẍ]' },
                { to: 'y', from: '[ÝŶŸỲỴỶỸ]' },
                { to: 'z', from: '[ŹŻŽ]' },
                { to: '-', from: "[·/_,:;']" },
            ];

            /**
             * russian
             */
            sets.ru = [
                { to: 'a', from: '[А]' },
                { to: 'b', from: '[Б]' },
                { to: 'v', from: '[В]' },
                { to: 'g', from: '[Г]' },
                { to: 'd', from: '[Д]' },
                { to: 'e', from: '[ЕЭ]' },
                { to: 'yo', from: '[Ё]' },
                { to: 'zh', from: '[Ж]' },
                { to: 'z', from: '[З]' },
                { to: 'i', from: '[И]' },
                { to: 'j', from: '[Й]' },
                { to: 'k', from: '[К]' },
                { to: 'l', from: '[Л]' },
                { to: 'm', from: '[М]' },
                { to: 'n', from: '[Н]' },
                { to: 'o', from: '[О]' },
                { to: 'p', from: '[П]' },
                { to: 'r', from: '[Р]' },
                { to: 's', from: '[С]' },
                { to: 't', from: '[Т]' },
                { to: 'u', from: '[У]' },
                { to: 'f', from: '[Ф]' },
                { to: 'h', from: '[Х]' },
                { to: 'c', from: '[Ц]' },
                { to: 'ch', from: '[Ч]' },
                { to: 'sh', from: '[Ш]' },
                { to: 'shch', from: '[Щ]' },
                { to: 'y', from: '[Ы]' },
                { to: 'yu', from: '[Ю]' },
                { to: 'ya', from: '[Я]' },
            ];

            /**
             * bulgarian
             */
            sets.bg = [
                { to: 'a', from: '[А]' },
                { to: 'b', from: '[Б]' },
                { to: 'v', from: '[В]' },
                { to: 'g', from: '[Г]' },
                { to: 'd', from: '[Д]' },
                { to: 'e', from: '[ЕЭ]' },
                { to: 'zh', from: '[Ж]' },
                { to: 'z', from: '[З]' },
                { to: 'i', from: '[И]' },
                { to: 'y', from: '[Й]' },
                { to: 'k', from: '[К]' },
                { to: 'l', from: '[Л]' },
                { to: 'm', from: '[М]' },
                { to: 'n', from: '[Н]' },
                { to: 'o', from: '[О]' },
                { to: 'p', from: '[П]' },
                { to: 'r', from: '[Р]' },
                { to: 's', from: '[С]' },
                { to: 't', from: '[Т]' },
                { to: 'u', from: '[У]' },
                { to: 'f', from: '[Ф]' },
                { to: 'h', from: '[Х]' },
                { to: 'ts', from: '[Ц]' },
                { to: 'ch', from: '[Ч]' },
                { to: 'sh', from: '[Ш]' },
                { to: 'sht', from: '[Щ]' },
                { to: 'a', from: '[Ъ]' },
                { to: 'y', from: '[Ь]' },
                { to: 'yu', from: '[Ю]' },
                { to: 'ya', from: '[Я]' },
            ];

            // first try user locale's sets
            if(Canvas.user.locale in sets){
                sets[Canvas.user.locale].forEach((set) => {
                    text = text.replace(new RegExp(set.from, 'gi'), set.to);
                });
            }

            // after that use detault sets
            sets.default.forEach((set) => {
                text = text.replace(new RegExp(set.from, 'gi'), set.to);
            });

            return text
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w-]+/g, '') // Remove all non-word chars
                .replace(/--+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        },
    },
};
