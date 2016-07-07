
namespace app.components {
  export interface ITrack {
    title: string;
    artist: string;
    prevLyrics?: string;
    soundCloudId?: string;
    duration?: number;
    albumThumbnail?: string;
    comment?: string;
    comments?: Array<ICommentTrack>;
    soundCloudPermalink?: string;
  }

  export interface ICommentTrack {
    content: string;
    authorName: string;
    authorPic: string;
    date: string;
  }
}
