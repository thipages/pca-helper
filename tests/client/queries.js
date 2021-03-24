const users=[
    ['tit','titpass']
]
export default (jca)=>[
    [
        ()=>jca.logout(),
        '#1011',
        'FORCED logout' // special FORCED comment, always pass test
    ],
    [
        ()=>jca.register(...users[0]),
        '{"id":1,"username":"tit"}',
        "tit registers"
    ],
    [
        ()=>jca.login(...users[0]),
        '{"id":1,"username":"tit"}',
        'tit logs'
    ],
    [
        ()=>jca.create('note',{document:'V2VsY29tZSE='}), // "Welcome!" in utf8
        '1',
        'tit uploads a file'
    ],
    [
        ()=>jca.create('note',{document:'V2VsY29tZSE='}), // "Welcome!" in utf8
        '2',
        'tit uploads a file'
    ]
]