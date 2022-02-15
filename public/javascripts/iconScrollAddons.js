let iconSelect;

window.addEventListener('load', function () {
    fetchIcons();
})

function initSelector(data) {
    let selectedImg = document.getElementById('selectedImg');

    document.getElementById('my-icon-select').addEventListener('changed', function(e){
        selectedImg.value = iconSelect.getSelectedValue();
    });

    let icons = [];

    for (let elem of data) {
        icons.push({'iconFilePath':'/' + elem, 'iconValue':'/' + elem});
    }

    // let icons = [];
    // icons.push({'iconFilePath':'/assets/images/market_icons/trooper_helmet.png', 'iconValue':'/assets/images/market_icons/trooper_helmet.png'});
    // icons.push({'iconFilePath':'/assets/images/market_icons/dark_vador.png', 'iconValue':'/assets/images/market_icons/dark_vador.png'});

    iconSelect = new IconSelect("my-icon-select",
        {
            'selectedIconWidth':48,
            'selectedIconHeight':48,
            'selectedBoxPadding':5,
            'iconsWidth':48,
            'iconsHeight':48,
            'boxIconSpace':1,
            'vectoralIconNumber':1,
            'horizontalIconNumber':1
        });

    iconSelect.refresh(icons)
}

async function fetchIcons() {
    let response = await fetch('http://codewars.local/management/items/fetch-icons');

    if (response.status === 200) {
        let data = await response.json();
        initSelector(data);
    }
}