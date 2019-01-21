# YTPlayer
A Wordpress plugin that shows a youtube video into an IFRAME using Youtube IFRAME API.

It can be handled using a shortcode to invoke the YT video.

## Only with the Video ID
### Example:
```html
[videoyoutube idvideo="QLd8Bxzyh1k"]
```

## Or with the Video ID and more parameters like that:
```html
[videoyoutube idvideo="QLd8Bxzyh1k" autoplay="1" loop="1" controls="0" mute="1"]
```

NOTE: some browsers block the autoplay feature if you dont set mute="1".
