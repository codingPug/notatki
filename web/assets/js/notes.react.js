var NoteRow = React.createClass({
    handleClick: function() {
        $.ajax({
            url: 'api/del/',
            type: 'post',
            data: {
              'id': this.props.note.id
            },
            success: function (data) {
                // ninja response handler
            },
            error: function (data) {
                console.log(data);
            }.bind(this)
        });
    },
    render: function() {
        var title   = this.props.note.title,
            text    = this.props.note.text,
            date    = this.props.note.timestamp.date,
            id      = this.props.note.id;

        return (
            <tr>
                <td>{id}</td>
                <td>{title}</td>
                <td>{text}</td>
                <td>{date}</td>
                <td><button type="button" onClick={this.handleClick}  className="btn btn-danger">usun</button></td>
            </tr>
        );
    }
});

var NoteTable = React.createClass({
    render: function() {
        var rows = [];
        this.props.notes.forEach(function(note) {
            rows.push(<NoteRow note={note} />);
        });
        return (
            <table className="table table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>tytul</th>
                    <th>tresc</th>
                    <th>data dodania</th>
                </tr>
                </thead>
                <tbody>{rows}</tbody>
            </table>
        );
    }
});

var SearchBar = React.createClass({
    render: function() {
        return (
            <form className="form-inline">
                <div className="form-group">
                    <label for="searchForm">Wyszukaj po treści</label>
                    <input id="searchForm" className="form-control" type="text" placeholder="Wyszukaj..." />
                </div>
            </form>
        );
    }
});

var FilterableNoteTable = React.createClass({
    getInitialState: function() {
        return {notes : []};
    },
    loadNotesFromServer: function() {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            success: function (data) {
                this.setState({notes: data})
            }.bind(this)
        });
    },
    componentDidMount: function() {
        this.loadNotesFromServer();
        // setInterval(this.loadNotesFromServer, 1000);

    },
    render: function() {
        return (
            <div>
                <SearchBar />
                <NoteTable notes={this.state.notes} />
            </div>
        );
    }
});

ReactDOM.render(
    <FilterableNoteTable url="/notatki/web/notes/" />,
    document.getElementById('app-container')
);


