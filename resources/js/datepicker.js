export default function() {
    let datepickers = Array.from(document.querySelectorAll('.datepicker'));

    datepickers.map((element) => {
        const picker = new easepick.create({
            element: element,
            css: [
                "https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.css"
            ],
            lang: 'ru-RU',
            zIndex: 10,
            format: 'DD.MM.YYYY',
            // plugins: [
            //     "RangePlugin",
            //     "PresetPlugin",
            //     "KbdPlugin"
            // ]
        })
    });
}
