<script type="text/javascript" src="/js/@pnotify/core/dist/PNotify.js"></script>
<script type="text/javascript" src="/js/@pnotify/mobile/dist/PNotifyMobile.js"></script>
<script type="text/javascript" src="/js/@pnotify/confirm/dist/PNotifyConfirm.js"></script>

<script type="text/javascript">
    PNotify.defaultModules.set(PNotifyMobile, {});
    var __stack = new PNotify.Stack({
                    dir1: 'down',
                    modal: true,
                    firstpos1: 25,
                    overlayClose: false,
                    push: 'top'
                });
                
    const _confirmAction = function(title, text){
        return new Promise((res, rej) => {

            const notice = PNotify.notice({
                title,
                text,
                icon: 'fas fa-question-circle',
                hide: false,
                closer: false,
                sticker: false,
                destroy: true,
                stack: __stack,
                modules: new Map([
                    ...PNotify.defaultModules,
                    [
                        PNotifyConfirm, {
                            confirm: true
                        }
                    ]
                ])
            });

            notice.on('pnotify:confirm', () => {
                res();
            });

            notice.on('pnotify:cancel', () => {
                rej();
            });
        });
    }

</script>