<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SpeakUp!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        .glass-home {
            background: rgba(255, 255, 255, 0.2); /* Semi-transparan */
            backdrop-filter: blur(10px); /* Efek blur */
            -webkit-backdrop-filter: blur(10px); /* Untuk Safari */
            border-radius: 10px;
            padding: 10px;
            position: relative;
            z-index: 10;
        } 
    </style>
</head>

<body class="bg-gradient-to-r from-blue-500 to-purple-500 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-1/5 bg-white p-6">
            <h1 class="text-3xl font-bold mb-10">SpeakUp!</h1>
            <nav class="space-y-6">
                <a href="home.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold active">
                    <img src="icons/home.png" class="w-6 h-6" alt="Home" />
                    <span>Home</span>
                </a>
                <a href="#" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold bg-gray-300 rounded-lg px-4 py-3">
                    <img src="icons/message-click.png" class="w-6 h-6" alt="Message" />
                    <span>Message</span>
                </a>
                <a href="community.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/community.png" class="w-6 h-6" alt="Community" />
                    <span>Community</span>
                </a>
                <a href="bookmark.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/bookmark.png" class="w-6 h-6" alt="Bookmark" />
                    <span>Bookmark</span>
                </a>
                <a href="settings.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/setting.png" class="w-6 h-6" alt="Settings" />
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="flex items-center justify-between bg-gray-200 p-4 shadow">
                <!-- Kategori -->
                <div class="flex space-x-4">
                    <a href="#" class="px-4 py-2 bg-white rounded-md hover:bg-gray-100">Friends</a>
                    <a href="#" class="px-4 py-2 hover:bg-gray-100">Request</a>
                </div>
        
                <!-- Search Bar -->
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search"
                        class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <img src="icons/search.png" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                </div>
        
                <!-- Navigasi Tanpa JS -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/note.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/notification.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/globe.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/profile.png" width="28" height="28" />
                    </a>
                    <a href="login.php" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/logout.png" width="28" height="28" />
                    </a>
                </div>
            </header>

            <!-- Main Chat Section -->
                <div class="flex flex-1 h-full">
                    <!-- Chat Area -->
                    <div class="flex-1 bg-sky p-6 flex flex-col">
                        <div class="flex items-center border-b pb-4 mb-4">
                            <img class="w-10 h-10 rounded-full" src="data:image/jpeg;base64,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" alt="User" />
                            <span class="ml-3 text-lg font-semibold">Iron Man</span>
                        </div>
                        <div class="flex-1 overflow-y-auto space-y-4 p-4">
                            <div class="flex justify-start">
                                <div class="bg-gray-300 p-3 rounded-lg max-w-xs">Hadalodo Bodor.</div>
                            </div>
                            <div class="flex justify-end">
                                <div class="bg-blue-500 text-white p-3 rounded-lg max-w-xs">Hadalodo judugada, madantadap kadalidi!!!</div>
                            </div>
                            <div class="flex justify-start">
                                <div class="bg-gray-300 p-3 rounded-lg max-w-xs">Kadamudu judugada.</div>
                            </div>
                        </div>
                        <div class="flex items-center border-t pt-4">
                            <input type="text" class="flex-1 border rounded-full p-2" placeholder="Write a message..." />
                            <button class="ml-2 bg-blue-500 text-white p-2 rounded-full">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
        
                    <!-- Chat List -->
                    <div class="w-1/3 bg-gray-100 p-6 border-l overflow-y-auto">
                        <h2 class="text-lg font-semibold mb-4">Chats</h2>
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-white rounded-lg shadow cursor-pointer">
                                <img class="w-10 h-10 rounded-full" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMSEhUSExMWFRUXGBkaGBgXFxgeHRkYFRgWGBcYFxcYHiggGBolHRcYITEhJSkrLi4vFx8zODMtNygtLisBCgoKDg0OGhAQGislHyUtLS8tKystLS0tLS0tLS0tLS0tLS0tLS0tLS0rLy0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAMsA+AMBIgACEQEDEQH/xAAcAAACAgMBAQAAAAAAAAAAAAAABQQGAgMHAQj/xAA+EAABAwIDBQUFCAEDBAMAAAABAAIRAyEEEjEFQVFhcQYTIoGRMkKhscEHFCNSYnLR8IKS4fEIM6KyFmPC/8QAGgEBAAMBAQEAAAAAAAAAAAAAAAIDBAEFBv/EAC4RAAICAQQABQIFBQEAAAAAAAABAhEDBBIhMRMiQVFhgZEFMnGh0TNCscHxFP/aAAwDAQACEQMRAD8A4chCEAIQhACEIQAhCEAIQhACEIQGdKkXGGgk8lKoYQB0VJECSB8p+t15gxDHOBIMgCDu976cFpdWl06oCyYCsTZvgpT7PHrqSn9Fs3DQJET7Jgc9RrNvoqF9/cNLQLRz3qWzapyZBN7a+ZP95qtwsmmPsZTY1uYvl0iOJvcX+aW4raQa3wkNM2y6zvcf1RYE80qq1WwTq7iPpO7yUcEutAnj/JXVGiLY4wdR1YgnOSJLfFYWtJJ43Xu0MEKjS5paXgklrb2AG/1PS/GFgr92C2z+d/CTw4nmssHUjxTF76+kjebrtAglCYbUpthtRls1nCB4XDdb1S9SOAhCEAIQhACEIQAhCEAIQhACEIQAhCEAIQn1XZTKbaRe4DPQ724NyXPAaOZgfFcbosx43N8CFCnbTwLqeR2UhtRudnMSQYO+CCFBXURlFxdMELdQwznyWiQIk7hOkndKxr0HMMOESARzB0IXLG2Vbq4NaEIXSIwxJGUAbhE8jH1S9bnPsOilbCwPfVmUyLE+LoNf7zR8BIMLserUaHNaYOh6LW/ZlVtjTd6fwuzbMwjGANa0QNBCZOwYAjIInhxWfxn7Gtade58/1GxrI6rEuXZdqbDoEz3bZ6KuY3s9S3NAPIKSzJkJado52smu3K04jZDSMsKrOaQSDqFYnZTKNE7E2pQNM/HWxvGkjSeqXqXrRJ4OEiBpBg8ZlRFIiCEIQAhCEAIQhACEIQAhCEAIQhAAWbqRFyITXsvhm1Kr2O30qmX97W5m/EfNeV8U18NLA0QGmP0iM1/elRcqZpx4FOG66FCfbXquqfd2k2bQYG23XJ+MpXjME6nBIOV0ljoMOAMGDxBsRuTmvjc1HDkNu0QSONMlp9WlnpzSXVjCmm4McYSiMZsmpSI/GwbjVpT71F098xp/T7cdVRFf+wmNb9/oMqHwVXOpuE+7VaWCR1IVMxOHNDEOpuEmlULSDvNNxBB9Ei7Q1EFGdJj7EYs0cHSptgAVJIIBzvDZqOcD7QEtYJ3A8So+36pqYTB1XXf+PTn9FNzHMHkargolesX0w1xnLZo4ZiSfU8V7teoe5oUxORpqFsgSc3d5jM38TSNBpvUYvktz3tpdcCdCEKwwns2Vx7B0myXR4pjnHJU5qun2f05z+L2XC3Ua/BRn+UnjVyR0nZx3ptjsR4dL206JTgW3spmLrAwJIM/3VZY/lNr/ADIVbRdbzSLHPO7inuLAc0gn3w2/kle0Y0G5ciuTs5cCehSzPy+fkFVNu7IcypJBAceHx9Fc8ER3hbmGZwgCRxVs7U7Ea7B0yQBUYfCerH/ULVFcGCcuTiG0nABrQIHtEcTpPwUFOu0lJzSxj2hr2AsMCJDYLSY1PiN+iSqZxqgQhCHAQhCAEIQgBCEIAQhCA34LCuq1G02+04wOZOgUuvsotY18tAcYgkSLkeJuoFjfkoOHrFjmvbq0gjqDITDFDM/PMtqeKep8U8wVGTZowxhKLTXJGwOJfh6zKgs5jgYO+N3Qj4FOsaaRqve1o7uoZAPuEw4dQbjyKX7SwRYG+IPadHCbcWkTotLcRNPu3Eyw+Do72m8r39Vx8osx3intZI2gARlbYWMbmm85eoWhtQd2Ga5XFwJ/UACP/EHyVgx2KoVsPRDaeR9OQ8NAAvrzJJg+qrj2ASQd48xx9VGLvgvzwUWpL1HW2Kzc1KrSOUhjCbR42RcKHj8S2rWNV5NR9Rud7t5rPb4pFgPHOnJT6myXHBMxGeRMZY0EkTO+4+KVbHoNdXY185XOgwePA8VyL4J54yeSLrsabUFLuaZpf91z3ZgNYkhtjYWi6Ubbd4mM/IwNPUOdm63JumfaPZjsPUbTL85LQQQINydRJvI3JTtpsVTAIENAneGtDZ9QVKBXrW1aquiAhCFYeaZUzBBOkhdC7HYLua+JZuBGXp4i34OC52uqdjqgq0jVaZdlYHjfna0sPqGg/wCSjLonDshbbxGKz/hVX5spdkY2zWiZzGwFgk+G7V48kAuDxMTlBnXQjWYK6NWoDKHNJa7UObqP7/CVbG2BUfXac0UmulxDWtk8AABJ+XFVKS2l2x7jTtYV6eDp1nACo6qHgXjLAsd40VFGLxWKc8Nc6GNc4gA6A6QNTfRde7fwaLRuLiua7MJw1V2U2qCCOmhCYmhlT6IvZ3ZVSWVntLmgy8SQ4NBAzXsbkLpmDquq7Oe95nK/3r2aADryJVS/EglroB13K87K7sbMrMdH/afmMxqwgkncrYuzPONHFe0ZM0g7XumkzrJkX9EnTLtDj+/ruePZENbzDRE+evmlq6uhJ2wQhC6cBCEIAQhCAEIQgBCEIAUzZ9eCQTqIubX4jgf4UNCMlCW12PtmupnPSrA3ENdJ8JHLesWZcO5xe3PNN7aZgRmeMsvB4Au84UfD1TUp5feaZ5kQBIPGwkcgeKkVqtN+Hg2rNfeZ8TSD6QR8VV0z0rjkx/K5T/0Z9mqtLv2is4im6QbwOWY8FltPCU3YlzaR8Drs3a7hwEzHko+HoMLMuQ57EOzbtYyxe3NO9nbKa0B7jlEgydZF/CBdSjBylwVzntx1OjXszA1wwtnwgwATOU2Mhp8Pmo1LLUllaq6mxrnlji0kB7jcuDRN4gkA7rWVspYtl3BtQkgSSLEjeOFtw4LOps/D1GFrSM3yJ3FpgrS9FkSujNH8Uwvy2UjaOIYYGZ73ttmz5m5eAkTPopvbGhS7jAPYMrnYXxt5srVWZp3kwfRLcVsxzXuA0bMnpu5lMsXWz4QMLCHUyC1xHtNByOYHcJqkwN5PFZqp0aJy8WLZU0LcMM4vyNa5ztwAJPoFsbs2sZilUMawx1utlMw07oiq5/Zhi8tarS/PTkdabgf/AFLlTnsIMEEHgU07P13UKjMVHgY/KeYc0h7Rzyk+oQJOzrOBdmdBJidycN2g1tRlJo3SeAaIufMgeaR4EgCQZm4PEG8jyKXV+02HwzqneHNUeYLQJhgmGmbAXJ8+Sy7X0bt8UrZZO2DQ6lBImMw5Gd65RtWs9paXRLXEEDdBsVK292tZWgU2PYAD7wAB/aJBCrTcZxbP++qtjjaKJ5VJl+2c7vw1rd4J9BKlY/FmnszEzq5rWjnne1p+BSbsXihJLNWiY5Gx+anduiHBmEY9oeYdlNg6C6G5tASSYn8oU48FUvM6ObIWVRhaSCIIMEHcRqFipEAQhCAEIQgBCEIAQhCAEIQgBCEIDOkJIAsSRCaYjEtdlzA5h7buMCAA3Qcz/SpBU57S7xcQHepg9bqMjRglVotXZ3Z9GqcwqSRcgcObTorT2X2GcZiiwnwt1gWDWmLDrYeZVH7J1wypciTYeZXTvsw2iylii1xjPLZP5s2Yeunkt2lVY5SXZi10nKcU+jp2D7L4Wm3KKTT1En1Kpfb7skxg+8UQGkR0B3ADgdPMLphcqj9pG0m08I9s+J8ADoQZ+Cjp8s/EXJXqMcPDfHRw3blHvKbLkDUkC/GPmkePwOSsKdGsMQCxj5Y02LxmyAHeLSrpSwOalLhFpH/kfqFh2R2vhWVsTVrGnSP4ZEACwZldkb+5sn9yq1leI6Nv4bF7I7io4A4lrs1Jz6ZJguacsEWIkaAclYu0/ZnEYRgdXxBJc1xAa55uBmgkmNN6rbtsZA+kzxMzuLXHeCTFlntbb2LxxpsqvLsjYaNABABceM7ysaR67yRSSjy/b5JW0fu1TDs7tgL2QXuvmvZxe4/qIgaWKV1sY0Ue5kZQ7MBF8xEEyOXHgFp2qSwCgBDfaJ3udcSeIG4KNhBTMsqDKTMP8XhIBgEC0EwJhTUeOzHm1HmaUEmP+z3ac0mtouBeJAaZiAToeXBM9i9nwKlSrVf4iTlAg2mZOYG6oT2kaq3dne0rQ3JXvAs47wOPNJp9oy42r5J+0G4Sm4jvy14sYYwuvwhirbqVFxIa57h+q3wC39pto0K5zU2ZHbzPtDmlODqBrtJUkuDs5264HexGmi7vGmBmDY43kjp/K3dsx32Lo91rUp0xrfNmLZMXnQpTisRUcYax2UCBY79StOGrvo1G1SPG0hwzcrhOgoW7GX2g7N+77QxFPdmkHiHAGfWfRVxdzrVqdbDU24ihSrPdh/vFXO0FwdVqVS8tcIczfEHRsblyzbOyKIqkYepYgFrXnjPha/Qxzg+abkdeCVbkV9C2V6DmHK5paeBC1qRQCEIQAhCEAIQhACEIQAhCEBnRZmIHFN6lMup2mG3jg0w35geqj7Cohz3cmH4wPqmeDw9QzA8JIGmoO7pCqnLmj09Hg3QuuxRQq5HSrls/a1OrlJd3dUe8fZfzMXa/noeW+n4ujlPxHMHQ+i0NcbQrcWaUHaMuowRn5ZHZcN26xdNuRr84GhMH0J3JNj9uCqe8xVWd4bxM6f2yoNDaL2iJUatULtTKterfokiiOiS7dlr272tc8ZKQDW6TvVOqG8oNRS8Bgy6KhaSwOA011PmLLM36s1drbE1tpPyBwbcm1rxuIU3/AORY2nbv6jYAbNpAbYNzRIA0hNts0QKeZ1pAjnwjlCjYPC0q7IFQiqBq7R0DRwFwRxvPNVxyqraJQwyyPamKMRWfVmpWqPc/QOe4umLxfTVacRSOUZtbx0EfC9vNNMlShmzHWzYdYniCDoPqEuqPnUDqrNxHwPchlq8hSO7WGRd3FbwmpbaGoPCFvLcrY9468huHnr6L3B4U1HBo3rrkIYuRx94c5gApM5uJud8xKPumd7XPfRkbnOIaTJiZbzG/cnOJwdCnT8THOdHtNeQbADQy06cFXfu76k5AXcrb9LSobWelKScKkdR7N05w2NxVVzXuMsyMcCIqTTpU2ObMjI5xEb38QVzKvs4VM7sM12VsZqLnZnMJucroGYa2IBGkHVbNjbTfTz4Z+ZtN5BdlJDg5kkEEHqPNM9m7QLKne+28iCXmZHMiJ68lKjLCDyStMrVLHWyPGZo91+79p1aenoVuxHZytcsY5zYkRlJyuu2Q0zMclZsVhmYonvmNa7UPYIt+rWw4kEcYWnAbJxOHOQtNSlq0sIzsDr5mDeDvFwU/Q68K3edX8r+CpV9lVWND3MMExumRxbqPMKLVpOaYcC08CCPmrftfaFSnZ7WVW/raWn/Km4SOosoNPtE4AMawZDqyp42Dk3Ndo5TCbmQlgwt+WX7FbQnWK7mrfu+6d/8AWSW/6HXHkfJLsRg3MGbVp94aTwPA8iuqSZnyYJw57XuRkIQpFIIQhACEIQDnsw4Co6fy/ULoGw8BDG1XR3YFuZXP+ydRgxAFT2XNcPOJHyV3xe0A6k2kwZWtP/BWfIvMfR/hU14H6NlPxAptqvp1A4tBIGVwBBB3SCCORSrEFgccgcBuzET8LJ5tPAtqVQS8NDvaJvEDWN+iV43ZjqZgEVBuLfq3UFTiefqIyTar6kLOvQ9bBhnH3Hf6St+G2dVcQG03SeUfNS4M8Yzb4NFClmk7gJKt3ZZwIpUz71YCORkfUqbg+wFQ0C+rVbSdYhh3jfm3zw3JC2scNWAbcszEf6SB8SqsjdUjdhh4cXKX6fckdpq+ZxEQGuIb05eiruIwz2FrhPjEiN94I9fmne2MU+swOIAymT5pVh6ZrVGskkNB03QC6B6LmDiPJgyxuaUfoaqjnWz+1wnd03LFMq2yWNYXNL55xH0ul0Kba9DSseSH5zwLdh2NJ8RgD48v7zWsBZgLlk1Gz2o2STG/evWVHNMix5LZRqRY6fJSjhwf5XY8ssWO1wFOu9+riVNoYI2OhVo7J1MG7KzE4em06Co2Wg8M1/Ceeh5LpFL7PsM9uZg/8n/Ir0YRhFeYwZtS4PbTs4oNkt1gg9ZB/hbKWAIK7Q/7OWbiR/l/IUTEfZ0dxPwV14H6mRa6cf7WcqpZ2HXmItB5FWvY0VhlblbVE+B1qdSdSCBNF8+80FpnxNJ8SY4zsBXGgJ/xP0Kru0ti18IO9LmgNItJDrmBAPr0VWXDBq4s1YtbDLw+GWajqWuYHFkd5RrMa4tB3uYZDmnc9pLTuM2Srt19mDKtL79sxoBAmphxJFtXUZ3/AKPSDYxKvas1qbWuOStSk0arYztPCd7ToWGx4LqfYTb1DFMJYGtqts9rbB0WztbwOsbliquCWZS7Z8w0jIggTxvPTh8FYdidnqlYxS8eaxpn3hwBm54THVTftM7LvwW0KkD8GsX1abtwB8T2ngWk6cC3iuk/Y/s2m5ora2lh5EX+ar28m7Dkx+E5y9EcD25sx2GrOpOBEXE6weI4gyDzBS9dq/6i9itY7D4pojOXMfzMBzT8CuKq08eVXaBCEIRBCEIDZQqlrg4agg+itlPFXEXBFr6jd6Knp1snFAtyOElukaxy5j5dFCaN+hzbZbb7GFZpzkuESLdOoW/D0QTwUeliQbZgetlLoUYMt/lVs9bGk2NqVGBY/Bv8LQMQ+kH1G6sEjrO+EOqOjglu2saG0e7YZLjLyPlKhTL8myMXKiTT7S1KzXNdqdeaWYZtIky455Osx6qvl68dVKk8Vrs8fNrnKKi10WLaT6QoEZ/xA60H2mnWei1dkK9Nrn53Q5wAbPxVdJQR/f70Uo4UouNmSGpccinS49C1ba1sZHySRwRhsU+L+JoG8wQBwd/ysg5r/ZN+DrHyOhTY0a5aqGV+xg0qRTErSWEGCI6qRRaoSL8Zk+gRqI/uo4rKhULLajh9RwKYYV9spAc06g/MH3TzCyxOzbF7Jc0a8W/u5fqFuhsuxZe8T7JuzqoI1XQ+xnaqph4Y6X0vynVv7Dw/TpwhcloVDTMj04qx7Px03BXqYZxnHbIw6rT+Ivk+j9n45lZgexwcD/YI3Hkpa4psHtC+g7M10cQdHciPrqum7D7S0sQ2xyuHtNJuOc728/WCqsuBx5XKPIblB1NDDa2ObQpuqO3aDidwXAu3O1TWeQTMEk/uPDkBZXft/wBpMxhp8Is0cTvcen1XH9s4qbT1WnHjWPHul2R0u7Nm3f2rr5+RezEEOnhfzGnxhPOx+3nYeqxzXZSDY/z8lWS7VYtfBleZOVyPbj8n0J9otSnj9kiqIlz6TR+h7qjWkjpJ6gp12T2d92oMpsHsDKOggGea512Rf3+xMbTDiatOKwHDIAbD/ErpvZvE987MHWjN/qAMBSiUpbYSS9Cj/wDUJi6ZwNGk57e+70VAyb5Mr2l3SXAL5/XVf+oWuDjqbfy049TK5UumGXYIQhCIIQhACypvIIIMEaLFCAaMcK2gh/5ePNv8KM7O06kesqKDCYHaheAKozxbNo6OZjxeag410a45oz4m6fv/ACajjan5neqxdiHHUuP95phQxWGNnd4PJp+qZUW7PIviHN60nn5BRb+DSsakv6q+rK1B4EoLTGgTbaj6DbUqgfzyPH/tCTvfzXU2yjLCEHSkn+lGFWnBiQeY0UrCsEGYs2RI3yB/+/gowMm+imYWDOsaR6n+FNvgzRinNJGDn7so8pHyMLPBYE1XENa6wJMCbC5t0WTKYcQ0NMk2v/sujdkdnU6NMvFQPeRDnU3QabdSwtEOubkw4GBuAmmeTarNPhc3XBQatMWjdZZUjGotxH8J/tx9Ko8uno6AD1dAvPRJHAtP5hxH1G5RSbXJqx58d8cf4J+GAMEXCa4eqWQQYP8AbcxG7qkeH1zNMfEHqN6dYF4dANnfA/tP01XD1sMk+Ge7S2W1zTVoiwEvp728XM4s4jVvTRPSeWmQrOzMwhwlpGhULaeCa4GrTEEXewbv1sH5eI93p7M4To5lw110eYfG6EKUdtOY5rmPLXM0I4+914cwEiZVyzxi3Xjzi6jlxWyGqaMWXTwn2hvtfbr6zi58X3AQBzA3an1PFVrFTJn/AJHEclLKxIBEOmBcECY4iOG/r1VeTUOXBV/54wXlRBha3rfUb/f4Ueosy7OT4Rffse2mKeMFF/sV2upOH7xA+MKBV+0DG4Gr3NBzGij+GSWh2fKA0uvoDG5VXB1yxwc0kEcFl2hwj2vZVeZOIZ3wP7nva6P8mOVsWY88pRXD77GHb7bT8ZXp4h8Z30aZcG2AcZJgblWVsrvk9AB6ABa1MxydsEIQhwEIQgBCEIAQhCAEIQgMw1eNbM8hPosgbea2ueBfKCCPQmxQk0aWRvTLDYOpl8LHO1JIaSJ0iQN0fNLhUAuBfdy59UyoR4Q6S1rQXAGJm8TukmFGXRZgT3Wh5gdkOYwOF6jhcHcDuH8pRiHua46g9eOtxqE5O3mOHhEECGtIFt3hJIiBzKj0mufJLHEfqAHoQTPoqUvVmzx5pba4ImH2jHtCRxaYP8LcMawey0g84v1GihYqkAbW5f8ABQacAEXbx4HgeCOyUIQny0TaFQSZGu8ajnz6JjSbuNweG/gQdQeeoSehqm+FNo3fLmOagenijxSXHsOqW0vBkqX/AC1I1HB4Gjx8dRviPTL84LZbB9oi/k0/X0KMMCLf0piykZkiy5Z6GPDceZcfv9X/AMKvjcIaby0+XMG4KiPVn2+1hpd44huQgAuMZg73ROpGscJVVfjKf5x8VJWYs2zHJxbS+p6AvFgMUz87fVHeg6EHoQjsp3xfTRjWiP7Y8VCe1b8Qdy0kmIXUzNkXPBL2HgRXrspl2UE+Z/SOZ/vBXP7Q8MwbLwFemB4KmJoEx7pqOcAAeGV1+qo+zx+NThxbDmnM2xEEEkHiIt0XRu1zjV7PUnkexiQRyDjWA62cFOLpmLPF7N3ycgQhCuMIIQhACEIQAhCEAIQhACEIQGxgseULCVnREmBvssHC6HfQ2MozB5/SVNJIbP5r+QkD6rXg6BcCToD/AMnos6hsL8viq5P0NmCFLcRwbre15GhI6LQVslRZZB0ZZlvw9YtMjzB0I4FR1k0qLLYjNrR7TdN4/Ly59U1wQSHC1IPEbxxCsGAbfjvB4g6H+75UGejpH5qH2CwhLcw1Gn8ef8LLaO2qFBgLvxHubLKYMWO951a3lqd3FbMRtQYXDOqWLzDaYO95+gFz6b1z44QVpcwnvJl0nedXT1+e7fKMV6ktZqpwk4Yyw42kcTSp4h/iLswiIazK4jKxos0RHXfKRVsIAdAmmz+0NXC0jha+HFRgc5wMlrwXQHQ67XNtIt5rRidpYepdpczk9unmyQuuLM0MuKUalxL59fqKXURwWmrRHBTqxZqHtI/cPlMqKXAmMzfifkESZTk8OuWjThSfZP8AifopAZAzeQ67/QfMKFi9ZG7+ypxqZmtPL4yZ81KS9SjC3bh7BgGy8Debetvqul9q6JZsXEUyR4a7bDm9rh5xUuqT2UwfeYmiy0ueNdwb4iT6fBWzbdB1XAYxzCXmq41oFwAK5cIHJgE/tjcoJ+dI5qlWNI5KhCFpPNBCEIAQskIDFer1AQHiFkvEB4vFkvEB6wwQRqFa9s7Nw9WlhKuHqRVr5u9pEGKeTV2bSJzW1iFU01wDpp0+VcRyDm+IdDlC4y3Fy9r6ZOxVFrRlbMRAnkf90olOcb7PmfkkrtVSj1NQlFpIwcsgV4gKRlXZmFk1YBZBRZbE300+2PXHsmLGRPAwHD1g/wCpV9pW2vULaZIMSQD0IJI+AUUrZpWXw47/AGGG3cf3z7HwMGVnT3neZ+ACh7OH4tP9zfmo4KmbK/7rOp+RRnY+eSb9TsjOzWHxWHz0wKbx7TNaZ5hrvZ/xIXK+1ewG0HSGluswSW7ribjf8F1HshUPiE2hKu2tIF1xuapbq5OPTqc5Yvt8HNMPsqn3Tar6joJIDQBNjBuouJZTb7AdP6o9QmWLO7dw3XibJdUXN5B6WMFTIYbaFIwQJblGswPNYO3Lfs4/iP5McR1AsVLtFKW2S+xPZWdRcatN0ZGkA+UW5n6q/wD2U4umylSdVcAM+Q5j4Ye/KAZ45/iuabSMUz1H1U01D9yAm0n4F5HyC5XQ1PM9vsh99o3YhuDxD61Km9+FeM7QCG92c2V9N0yYB0jc4cFQcTTE5miBwuY8yvortM81Ni0Hv8TnNuSBfMx4M9YHovnunuVknTM6xRcPv+xBQsqgueqFMxs//9k=" alt="User" />
                                <div class="ml-3">
                                    <p class="font-semibold">Iron Man</p>
                                    <p class="text-sm text-gray-500">Kadamudu judugada.</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-white rounded-lg shadow cursor-pointer">
                                <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="User" />
                                <div class="ml-3">
                                    <p class="font-semibold">Faizal</p>
                                    <p class="text-sm text-gray-500">Ayo mokel</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-white rounded-lg shadow cursor-pointer">
                                <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="User" />
                                <div class="ml-3">
                                    <p class="font-semibold">Sophia</p>
                                    <p class="text-sm text-gray-500">sap broo??</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
