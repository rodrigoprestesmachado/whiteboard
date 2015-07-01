function getPlayerName( name ) {
    if (navigator.appName.indexOf("Microsoft") != -1) {
        return window[ name ];
    } else {
        return document[ name ];
    }
    return undefined;
}