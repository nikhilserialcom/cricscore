
let score_insert = document.querySelectorAll('.score-insert button');
let batman_score = document.querySelector('.batman-score');
let bowler_score = document.querySelector('.bowler');
let total_score = document.querySelector('.total-score');
const run_button = document.querySelectorAll('.run_button button');
const dropped_btn = document.querySelector('.dropped');
const save_miss_run_btn = document.querySelector('.save_miss_run');
const change_keeper_btn = document.querySelector('.change_keeper');
const break_btn = document.querySelector('.break_btn');
const change_team = document.querySelector('.change_team');

var wide_ball = document.querySelector('.score-card .score_modal');
const undo_modal = document.querySelector('.score-card .undo_modal');
const NoBowl_modal = document.querySelector('.score-card .NoBowl_modal');
const lagby_modal = document.querySelector('.score-card .lagby_modal');
const bye_modal = document.querySelector('.score-card .bye_modal');
const out_modal = document.querySelector('.score-card .out_modal');
const over_complete_modal = document.querySelector('.score-card .over_complete_modal');
const select_bowler_modal = document.querySelector('.score-card .select_bowler_modal');
const select_batsman_modal = document.querySelector('.score-card .select_batsman_modal');
const dropped_catch_modal = document.querySelector('.score-card .dropped_catch_modal');
const save_missed_run_modal = document.querySelector('.score-card .save_missed_run_modal');
const change_keeper_modal = document.querySelector('.change_keeper_modal');
const match_break_modal = document.querySelector('.match_break_modal');
const change_team_modal = document.querySelector('.change_team_modal');

var wide_btn = document.getElementById('WD');
const nb_btn = document.getElementById('NB');
const lb_btn = document.getElementById('LB');
const undo_btn = document.getElementById('undo');
const out_btn = document.getElementById('out');
const next_over = document.getElementById('next_over');
const BYE_btn = document.getElementById('BYE');

const submit_nb_btn = document.getElementById('nb_btn');
const lagby_btn = document.getElementById('lagby_btn');
const submit_out = document.getElementById('submit_out');
const submit_undo = document.getElementById('submit_undo');
const submit_bye_btn = document.getElementById('bye_btn');
const select_bowler_btn = document.getElementById('select_bowler_btn');
const cancle_btn = document.getElementById('cancel');
const change_keeper_close = document.querySelector('.change_keeper_close');
const change_player_btn = document.getElementById('change_player');

var closeModalBtn = document.getElementById('closeModalBtn');
const closeUndoModalBtn = document.getElementById('closeUndoModalBtn');
const closelagbyModalBtn = document.getElementById('closelagbyModalBtn');
const classOutModalBtn = document.getElementById('classOutModalBtn');
const closebyeModalBtn = document.getElementById('closebyeModalBtn');
const closeNoBowlModalBtn = document.getElementById('closeNoBowlModalBtn');
const score_nobowl_model_input = document.getElementById('score_nobowl_model_input');
const score_modal_input = document.getElementById('score_model_input');
const score_lagby_model_input = document.getElementById('score_lagby_model_input');
const score_bye_model_input = document.getElementById('score_bye_model_input');
const submit_btn = document.getElementById('submit_btn');

const bowler_list = document.querySelector('.select_bowler_modal .player_list')
var player_id;
var bowler_Id;
var batsman_Id;
var striker;
var non_striker;

const showscoreUrl = 'php/admin/showScore.php';
const showFilderUrl = 'php/admin/showallplayer.php';
const droppedcatchUrl = 'php/admin/dropcatch.php';
const missfiledUrl = 'php/admin/saveandmissrun.php';
const chanegKeeperUrl = 'php/admin/changekeeper.php';
const matchbreakUrl = 'php/admin/matchbreak.php';
const showteamplayerUrl = 'php/admin/showteamplayer.php';
const addPlayerUrl = 'php/admin/add_player.php';
const undoUrl = 'php/admin/undo.php';


var showScore = () => {
    fetch(showscoreUrl, {
        method: 'POST',
        body: JSON.stringify({
            match_id: "65364c7e999af96e2f0d3ba7",
        }
        ),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            score = json.match;
            striker = score.striker;
            non_striker = score.non_striker;
            // console.log(striker);
            if (json.status_code == 200) {
                // console.log(score);
                total_score.innerHTML = `
                        <span>${score.team1_score}/${score.team1_wicket}</span><span class="over">(${score.team1_over}/${score.total_over})</span>
                        `;
                team1 = score.team_1;
                batman_score.innerHTML = team1.map(val => {
                    const { _id, playerName, bat_liveRun, bat_ball } = val;
                    player_id = _id;
                    if (_id == score.striker || _id == score.non_striker) {
                        return `
                                    <div class="player">
                                        <div class="playerName" id="${_id}">${playerName}</div>
                                        <div class="playerrun">${bat_liveRun}<span>(${bat_ball})</span></div>
                                    </div>
                                `;
                    }
                }).join('');

                // Get all elements with class "playerName"
                var playerNames = document.getElementsByClassName('playerName');

                // Initialize an array to store the IDs
                var playerIds = [];

                // Iterate through the player name elements using forEach
                Array.from(playerNames).forEach(function (playerNameElement) {
                    var playerId = playerNameElement.id;
                    playerIds.push(playerId);
                });

                // Log the player IDs
                playerIds.forEach(function (playerId) {
                    if (striker == playerId) {
                        let striker_player = document.getElementById(playerId);
                        striker_player.classList.add('icon');
                    }
                });


                team2 = score.team_2;
                bowler_score.innerHTML = team2.map(val => {
                    const { _id, playerName, ball_liveRun, ball_wicket, ball_over } = val;

                    if (_id == score.bowler) {
                        return `
                                <div class="player">
                                    <div class="playerName" id="${_id}">${playerName}</div>
                                    <div class="bowlerrun">${ball_wicket}-${ball_liveRun}<span>${ball_over}</span></div>
                                </div>   
                                `;
                    }
                }).join('');

                let bowler_id = document.querySelectorAll('.bowler .playerName');
                bowler_id.forEach(element => {
                    bowler_Id = element.getAttribute('id')
                    // console.log(bowler_Id);
                });

            }
            else {
                console.log(json.message);
            }
        })
}

showScore();

showRun = (run) => {
    // console.log(run);
    const over_ball = document.querySelector('.over-ball');
    var runDiv = document.createElement("div");
    // if(run == "W")
    // {
    //     runDiv.style.background = 'red';
    //     runDiv.style.color = 'white';
    // }
    // else if(run == "4")
    // {
    //     runDiv.style.background = #C5FFB0;
    //     runDiv.style.color = 'white';
    // }

    runDiv.textContent = run;

    over_ball.appendChild(runDiv);
}

const addscoreUrl = 'php/admin/addscore.php';

var add_score = (scoreInput, bowler_Id, striker, ballStatus) => {
    fetch(addscoreUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: "65364c7e999af96e2f0d3ba7",
            batsmanId: striker,
            bowlerId: bowler_Id,
            score_inuput: scoreInput,
            ball_status: ballStatus
        }
        ),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            const over_data = json.over;
            if (json.status_code == 200) {
                showScore();
                // console.log(over_data * 10 % 10);
                if (over_data * 10 % 10 == 0) {
                    over_complete_modal.style.display = 'block';
                    over_complete_modal.style.zIndex = "99999";
                }
            }
            else {
                console.log(json.message);
            }
        })
}

score_insert.forEach((element) => {
    element.addEventListener('click', () => {
        let scoreInput = element.textContent;
        let ball_status = '';
        add_score(scoreInput, bowler_Id, striker, ball_status);
        showRun(scoreInput);
    })
})

const NoBowl_btn = document.getElementById('NB');

wide_btn.addEventListener('click', () => {
    wide_ball.style.display = 'block';
    var icon = document.querySelector('.icon')
    icon.style.zIndex = "-1";
})

NoBowl_btn.addEventListener('click', () => {
    NoBowl_modal.style.display = 'block';
    var icon = document.querySelector('.icon')
    icon.style.zIndex = "-1";
})

var undo = (match_id,last_run,bowler_Id, striker) => {
    fetch(undoUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: match_id,
            removerun: last_run,
            batsmanId: striker,
            bowlerId: bowler_Id
        }
        ),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if(json.status_code == 200)
            {
                showScore();
                undo_modal.style.display = 'none';
            }
        })
}

undo_btn.addEventListener('click', () => {
    undo_modal.style.display = 'block';
    var icon = document.querySelector('.icon');
    icon.style.zIndex = '-1';
})

submit_undo.addEventListener('click', () => {
    const over_ball = document.querySelector('.over-ball');
    const match_id = "65364c7e999af96e2f0d3ba7";
    var batman_id;
    const lastdiv = over_ball.lastElementChild;
    if(lastdiv.textContent == "1" || lastdiv.textContent == "3"){
        // console.log(non_striker);
        batman_id = non_striker;
    }
    else
    {
        batman_id = striker;
    }
    // console.log(batman_id);
    over_ball.removeChild(lastdiv);
    undo(match_id,lastdiv.textContent,bowler_Id,batman_id);
})

lb_btn.addEventListener('click', () => {
    lagby_modal.style.display = 'block';
    var icon = document.querySelector('.icon');
    icon.style.zIndex = '-1';
})

BYE_btn.addEventListener('click', () => {
    bye_modal.style.display = 'block';
    var icon = document.querySelector('.icon');
    icon.style.zIndex = '-1';
})

const showPlayerUrl = 'php/admin/showplayer.php';

var showPlayer = () => {
    fetch(showPlayerUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: "65364c7e999af96e2f0d3ba7",
            teamId: "652f6a46e065cf214509e897",
        }
        ),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            const match = json.batsman
            if (json.status_code == 200) {
                // console.log(match);
                const select_batsman = document.querySelector('.select_batsman_modal .batsman_list');
                select_batsman.innerHTML = match.map(val => {
                    const { _id, playerName } = val;
                    return `
                    <div class="batsman_detail">
                        <div class="batsman_profile">
                            <img src="img/batsman.svg" alt="">
                        </div>
                        <div class="batsman_name" id="${_id}">${playerName}</div>
                    </div>
                    `;
                }).join('');

                const player_list = document.querySelectorAll('.select_batsman_modal .batsman_list .batsman_detail');
                const batsmanNameElement = document.querySelectorAll('.select_batsman_modal .batsman_content .batsman_list .batsman_detail .batsman_name');
                console.log(player_list);
                player_list.forEach((element, index) => {
                    console.log(element);
                    element.addEventListener('click', () => {
                        console.log(batsmanNameElement[index].getAttribute('id'));
                        select_new_batsman(batsmanNameElement[index].getAttribute('id'));
                        select_batsman_modal.style.display = 'none';
                    })
                })

            }
        })
}

out_btn.addEventListener('click', () => {
    out_modal.style.display = 'block';
    var icon = document.querySelector('.icon');
    icon.style.zIndex = '-1';
})

closeUndoModalBtn.addEventListener('click', () => {
    undo_modal.style.display = 'none';
    var icon = document.querySelector('.icon');
    icon.style.zIndex = '1';
})

closeModalBtn.addEventListener('click', () => {
    wide_ball.style.display = 'none';
    score_modal_input.value = '';
    var icon = document.querySelector('.icon');
    icon.style.zIndex = '1';
})

closelagbyModalBtn.addEventListener('click', () => {
    lagby_modal.style.display = 'none';
    score_lagby_model_input.value = '';
})

classOutModalBtn.addEventListener('click', () => {
    out_modal.style.display = 'none';
})

submit_nb_btn.addEventListener('click', () => {
    const score_with_no_bowl = score_nobowl_model_input.value;
    const ball_status = nb_btn.textContent;
    NoBowl_modal.style.display = 'none';
    add_score(score_with_no_bowl, bowler_Id, striker, ball_status);
    showRun(score_with_no_bowl + 'NB')
})

submit_btn.addEventListener('click', () => {
    const score_with_wide = score_modal_input.value;
    const ball_status = wide_btn.textContent;
    wide_ball.style.display = 'none';
    add_score(score_with_wide, bowler_Id, striker, ball_status);
    showRun(score_with_wide + 'WD')
})

lagby_btn.addEventListener('click', () => {
    const score_with_lagBy = score_lagby_model_input.value;
    const ball_status = lb_btn.textContent;
    lagby_modal.style.display = 'none';
    add_score(score_with_lagBy, bowler_Id, striker, ball_status);
    showRun(score_with_lagBy + 'LB');
})

submit_bye_btn.addEventListener('click', () => {
    const bye_run = score_bye_model_input.value;
    const ball_status = BYE_btn.textContent;
    bye_modal.style.display = 'none';
    add_score(bye_run, bowler_Id, striker, ball_status);
    showRun(bye_run + 'BYE');
})

const outPlayerOut = 'php/admin/outplayer.php';
const select_new_batsman_url = 'php/admin/selectplayer.php';

var select_new_batsman = (newbatsmanId) => {
    fetch(select_new_batsman_url, {
        method: 'POST',
        body: JSON.stringify({
            match_id: "65364c7e999af96e2f0d3ba7",
            teamId: "652f6a46e065cf214509e897",
            newbatsmanId: newbatsmanId,
        }),
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if (json.status_code == 200) {
                showScore();
            }
            else {
                console.log(json.message);
            }
        })
}

var outPlayer = (select_out, batsman_Id, bowler_Id) => {
    fetch(outPlayerOut, {
        method: 'POST',
        body: JSON.stringify({
            matchId: "65364c7e999af96e2f0d3ba7",
            teamId: "652f6a46e065cf214509e897",
            batsmanId: batsman_Id,
            bowlerId: bowler_Id,
            out_style: select_out
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if (json.status_code == 200) {
                showPlayer();
                out_modal.style.display = 'none';
                select_batsman_modal.style.display = 'block';

                // const select_player_btn = document.getElementById('select_batsman_btn');
                // submit_out.style.display = 'none';
                // select_player_btn.style.display = 'block';

                // select_player_btn.addEventListener('click', () => {

                //     select_new_batsman(select_player.value);
                //     out_modal.style.display = 'none';
                // })
            }
        })
}

submit_out.addEventListener('click', () => {
    const select_out = document.querySelector('.select_batsman');
    outPlayer(select_out.value, striker, bowler_Id);
    showRun("W");
})

const showBowlerUrl = 'php/admin/showbowler.php';

var showBowler = () => {
    fetch(showBowlerUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: "65364c7e999af96e2f0d3ba7",
            teamId: "652f7d3ae065cf214509e89a",
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if (json.status_code == 200) {
                const arr = json.bowler;
                bowler_list.innerHTML = arr.map(val => {
                    const { _id, playerName } = val;

                    return `    
                        <option value="${_id}">${playerName}</option>
                    `;
                }).join('');
            }
        })
}

next_over.addEventListener('click', () => {
    over_complete_modal.style.display = 'none';
    select_bowler_modal.style.display = 'block';
    var icon = document.querySelector('.icon');
    icon.style.zIndex = '-1';
    showBowler();
})

const changebowlerUrl = 'php/admin/selectbowler.php';

var changebowler = (id) => {
    fetch(changebowlerUrl, {
        method: 'POST',
        body: JSON.stringify({
            match_id: "65364c7e999af96e2f0d3ba7",
            bowler_Id: id
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if (json.status_code == 200) {
                showScore();
                const over_ball = document.querySelector('.over-ball');
                over_ball.innerHTML = "";
            }
            else {
                console.log(json.message);
            }
        })
}

select_bowler_btn.addEventListener('click', () => {
    changebowler(bowler_list.value);
    select_bowler_modal.style.display = 'none';
})

const dropcatch = (match_id, team_id, filder_id, missrun) => {
    fetch(droppedcatchUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: match_id,
            teamId: team_id,
            filderId: filder_id,
            missedRun: missrun
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
        })
}

const missFiled = (match_id, team_id, filder_id, filedstatus, missrun) => {
    fetch(missfiledUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: match_id,
            teamId: team_id,
            filderId: filder_id,
            fildeStatus: filedstatus,
            missedRun: missrun
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
        })
}

const changekeeper = (match_id, team_id, wicket_keeper_id) => {
    fetch(chanegKeeperUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: match_id,
            teamId: team_id,
            wicketKeeperId: wicket_keeper_id,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
        })
}

const showFilder = (match_id, team_id) => {
    fetch(showFilderUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: match_id,
            teamId: team_id,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            const filder_name = json.filder;
            if (json.status_code == 200) {
                // console.log(filder_name);
                const filder_list = document.querySelectorAll('.filder_list');
                filder_list.forEach(element => {
                    element.innerHTML = filder_name.map(val => {
                        const { _id, playerName } = val;
                        // const playerImage = playerProfile ? `<img src="php/${playerProfile}" alt="Profile Image">` : '<img src="img/filder.svg" alt="">';
                        return `
                        <div class="filder_detail">
                            <div class="filder_profile">
                                <img src="img/filder.svg" alt="">
                            </div>
                            <div class="filder_name" id="${_id}">${playerName}</div>
                        </div>
                        `;
                    }).join('');
                })

            }
            const player_list = document.querySelectorAll('.dropped_catch_modal .filder_list .filder_detail');
            const batsmanNameElement = document.querySelectorAll('.dropped_catch_modal .dropped_catch_content .filder_list .filder_detail .filder_name');
            var filder_id;
            var missrun;
            // console.log(player_list);
            player_list.forEach((element, index) => {
                // console.log(element);
                element.addEventListener('click', () => {
                    // console.log(batsmanNameElement[index].getAttribute('id'));
                    filder_id = batsmanNameElement[index].getAttribute('id');
                    // select_batsman_modal.style.display = 'none';
                })
            })

            run_button.forEach(element => {
                element.addEventListener('click', () => {
                    // console.log(element.textContent);
                    missrun = element.textContent;
                })
            })

            const done_btn = document.getElementById('done');
            done_btn.addEventListener('click', () => {
                const match_id = "65364c7e999af96e2f0d3ba7";
                const team_id = "652f7d3ae065cf214509e89a";
                // console.log(filder_id);
                dropcatch(match_id, team_id, filder_id, missrun);
                dropped_catch_modal.style.display = "none";
            })

            const filder_data = document.querySelectorAll('.save_missed_run_modal .filder_list .filder_detail');
            const filderElement = document.querySelectorAll('.save_missed_run_modal .filder_list .filder_detail .filder_name');
            let miss_filed;
            filder_data.forEach((element, index) => {
                element.addEventListener('click', () => {
                    miss_filed = filderElement[index].getAttribute('id');
                    // console.log(filderElement[index].getAttribute('id'));
                })
            })

            const run_miss_save_input = document.querySelectorAll('.run_miss_save_input');
            let select_value;
            run_miss_save_input.forEach(radio => {
                radio.addEventListener('input', () => {
                    // console.log(radio.value);
                    select_value = radio.value;
                })
            });


            const save_miss_btn = document.getElementById('save_miss_btn');
            save_miss_btn.addEventListener('click', () => {
                const match_id = "65364c7e999af96e2f0d3ba7";
                const team_id = "652f7d3ae065cf214509e89a";
                missFiled(match_id, team_id, miss_filed, select_value, missrun);
                save_missed_run_modal.style.display = 'none';
            })

            const wicket_keeper_data = document.querySelectorAll('.change_keeper_modal .change_keeper_content .filder_list .filder_detail');
            const wicket_keeper_element = document.querySelectorAll('.change_keeper_modal .change_keeper_content .filder_list .filder_detail .filder_name');
            let wicket_keeper_id;
            wicket_keeper_data.forEach((element, index) => {
                element.addEventListener('click', () => {
                    // console.log(wicket_keeper_element[index].getAttribute('id'));
                    wicket_keeper_id = wicket_keeper_element[index].getAttribute('id');
                })
            })

            const change_keeper_btn = document.getElementById('change_keeper_btn');
            change_keeper_btn.addEventListener('click', () => {
                // console.log(wicket_keeper_id);
                const match_id = "65364c7e999af96e2f0d3ba7";
                const team_id = "652f7d3ae065cf214509e89a";
                changekeeper(match_id, team_id, wicket_keeper_id);
                change_keeper_modal.style.display = 'none';
            })
        })
}

dropped_btn.addEventListener('click', () => {
    dropped_catch_modal.style.display = 'block';
    const match_id = "65364c7e999af96e2f0d3ba7";
    const team_id = "652f7d3ae065cf214509e89a";
    // console.log(run_button);
    showFilder(match_id, team_id);
})

// console.log(cancle_btn);
cancle_btn.addEventListener('click', () => {
    dropped_catch_modal.style.display = 'none';
})

closebyeModalBtn.addEventListener('click', () => {
    bye_modal.style.display = 'none';
    score_bye_model_input.value = '';
})

closeNoBowlModalBtn.addEventListener('click' ,() => {
    NoBowl_modal.style.display = 'none';
    score_nobowl_model_input.value = '';
})

save_miss_run_btn.addEventListener('click', () => {
    save_missed_run_modal.style.display = "block";
    const match_id = "65364c7e999af96e2f0d3ba7";
    const team_id = "652f7d3ae065cf214509e89a";
    showFilder(match_id, team_id);
})

change_keeper_btn.addEventListener('click', () => {
    change_keeper_modal.style.display = 'block';
    const match_id = "65364c7e999af96e2f0d3ba7";
    const team_id = "652f7d3ae065cf214509e89a";
    showFilder(match_id, team_id);
})

change_keeper_close.addEventListener('click', () => {
    change_keeper_modal.style.display = 'none';
})

break_btn.addEventListener('click', () => {
    match_break_modal.style.display = 'block';
})

const break_button = document.querySelectorAll('.break_button button');

const matchbreake = (match_id, break_type) => {
    fetch(matchbreakUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: match_id,
            breakType: break_type
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
        })
}

break_button.forEach(element => {
    element.addEventListener('click', () => {
        const match_id = "65364c7e999af96e2f0d3ba7";
        matchbreake(match_id, element.textContent);
        match_break_modal.style.display = 'none';   
    })
})

var addPlayer = (match_id, team_id, player_id) => {
    fetch(addPlayerUrl, {
        method: 'POST',
        body: JSON.stringify({
            matchId: match_id,
            teamId: team_id,
            playerId: player_id
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
        })
}

var showteamplayer = (team_id) => {
    fetch(showteamplayerUrl, {
        method: 'POST',
        body: JSON.stringify({
            teamId: team_id,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            const player = json.player;
            if (json.status_code == 200) {
                const player_list = document.querySelector('.change_team_modal .change_team_content .player_list');

                player_list.innerHTML = player.map(val => {
                    const { playerName,playerProfile } = val;
                    const playerId = val._id;
                    // const playerImage = playerProfile ? `<img src="php/${playerProfile}" alt="Profile Image">` : '<img src="img/filder.svg" alt="">';
                    return `
                    <div class="player_detail">
                        <div class="player_profile">
                            <img src="img/filder.svg" alt="">
                        </div>
                        <div class="player_name" id="${playerId.$oid}">${playerName}</div>
                    </div>
                    `;
                }).join('');
            }

            const player_list = document.querySelectorAll('.change_team_modal .change_team_content .player_list .player_detail');
            const batsmanNameElement = document.querySelectorAll('.change_team_modal .change_team_content .player_list .player_detail .player_name');
            var player_id;
            // console.log(player_list);
            player_list.forEach((element, index) => {
                // console.log(element);
                element.addEventListener('click', () => {
                    player_id = batsmanNameElement[index].getAttribute('id');
                })
            })

            change_player_btn.addEventListener('click', () => {
                // console.log(player_id);
                const match_id = "65364c7e999af96e2f0d3ba7";
                addPlayer(match_id, team_id, player_id)
                change_team_modal.style.display = "none";
            })
        })
}

change_team.addEventListener('click', () => {
    change_team_modal.style.display = 'block';
    const team_id = "652f7d3ae065cf214509e89a";
    showteamplayer(team_id);
})

window.addEventListener('click', (event) => {
    if (event.target == wide_ball) {
        wide_ball.style.display = 'none';
        score_modal_input.value = '';
    }
    else if (event.target == undo_modal) {
        undo_modal.style.display = 'none';
        score_nobowl_model_input.value = '';
    }
    else if (event.target == lagby_modal) {
        lagby_modal.style.display = 'none';
        score_lagby_model_input.value = '';
    }
    else if (event.target == out_modal) {
        out_modal.style.display = 'none';
    }
    else if(event.target == NoBowl_modal)
    {
        NoBowl_modal.style.display = 'none';
        score_nobowl_model_input.value = '';
    }
    else if (event.target == bye_modal) {
        bye_modal.style.display = 'none';
        score_bye_model_input.value = '';
    }
    else if (event.target == over_complete_modal) {
        over_complete_modal.style.display = 'none';
    }
    else if (event.target == dropped_catch_modal) {
        dropped_catch_modal.style.display = 'none';
    }
    else if (event.target == save_missed_run_modal) {
        save_missed_run_modal.style.display = 'none';
    }
    else if (event.target == change_keeper_modal) {
        change_keeper_modal.style.display = 'none';
    }
    else if (event.target == match_break_modal) {
        match_break_modal.style.display = 'none';
    }
    else if (event.target == change_team_modal) {
        change_team_modal.style.display = 'none';
    }
})
